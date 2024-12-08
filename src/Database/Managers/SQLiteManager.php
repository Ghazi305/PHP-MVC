<?php

namespace Proton\Database\Managers;

use Proton\Database\Grammars\SQLiteGrammars;
use Proton\Database\Managers\Contracts\DatabaseManager;
use App\Models\Model;

class SQLiteManager implements DatabaseManager
{
    protected static $instance;

    public function connect(): \PDO
    {
        if (!self::$instance) {
            self::$instance = new \PDO('sqlite:' . database_path() . 'database.sqlite');
        }
        return self::$instance;
    }

    public function disconnect(): void
    {
        self::$instance = null;  // Corrected here
    }

    // Helper function to bind values to the statement
    private function bindValues($stm, $values)
    {
        foreach ($values as $i => $value) {
            $stm->bindValue($i + 1, $value);
        }
    }

    public function create($data)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildInsertQuery(array_keys($data));
        $stm = self::$instance->prepare($query);

        $this->bindValues($stm, array_values($data));  // Using helper function

        return $stm->execute();
    }

    public function query(string $query, $values = [])
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $stm = self::$instance->prepare($query);
        $this->bindValues($stm, $values);  // Using helper function

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function read($columns = '*', $filter = null)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildSelectQuery($columns, $filter);
        $stm = self::$instance->prepare($query);

        if ($filter) {
            $stm->bindValue(1, $filter[2]);
        }

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }

    public function update($id, $data)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildUpdateQuery(array_keys($data));
        $stm = self::$instance->prepare($query);

        $this->bindValues($stm, array_values($data));  // Using helper function

        // Bind the ID value to the last placeholder
        $stm->bindValue(count($data) + 1, $id);
        return $stm->execute();
    }

    public function delete($id)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildDeleteQuery();
        $stm = self::$instance->prepare($query);
        $stm->bindValue(1, $id);

        return $stm->execute();
    }

    public function limit($count)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildLimitQuery();
        $stm = self::$instance->prepare($query);
        $stm->bindValue(1, $count);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }

    public function count($columns)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = SQLiteGrammar::buildCountQuery($columns);
        $stm = self::$instance->prepare($query);
        $stm->bindValue(1, $columns);
        $stm->execute();

        return $stm->fetchColumn();
    }
}