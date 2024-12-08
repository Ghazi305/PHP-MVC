<?php

namespace Proton\Database\Managers;

use Proton\Database\Grammars\PostgresGrammars;
use Proton\Database\Managers\Contracts\DatabaseManager;
use App\Models\Model;

class PostgresManager implements DatabaseManager
{
    protected static $instance;

    public function connect(): \PDO
    {
        if (!self::$instance) {
            self::$instance = new \PDO(
                env('DB_DRIVER') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
        }

        return self::$instance;
    }

    public function disconnect(): void
    {
        self::$instance = null;  // Corrected here
    }

    public function create($data)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = PostgresGrammar::buildInsertQuery(array_keys($data));
        $stm = self::$instance->prepare($query);

        foreach (array_values($data) as $i => $value) {
            $stm->bindValue($i + 1, $value);  // Corrected bindValue usage
        }

        $result = $stm->execute();
        $stm = null;  // Close statement

        return $result;
    }

    public function query(string $query, $values = [])
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $stm = self::$instance->prepare($query);
        foreach ($values as $i => $value) {
            $stm->bindValue($i + 1, $value);  // Corrected bindValue usage
        }

        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $stm = null;  // Close statement

        return $result;
    }

    public function read($columns = '*', $filter = null)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = PostgresGrammar::buildSelectQuery($columns, $filter);
        $stm = self::$instance->prepare($query);

        if ($filter) {
            $stm->bindValue(1, $filter[2]);
        }

        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
        $stm = null;  // Close statement

        return $result;
    }

    public function update($id, $data)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = PostgresGrammar::buildUpdateQuery(array_keys($data));
        $stm = self::$instance->prepare($query);

        foreach (array_values($data) as $i => $value) {
            $stm->bindValue($i + 1, $value);
        }

        // Bind the ID value to the last placeholder
        $stm->bindValue(count($data) + 1, $id);
        $result = $stm->execute();
        $stm = null;  // Close statement

        return $result;
    }

    public function delete($id)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = PostgresGrammar::buildDeleteQuery();
        $stm = self::$instance->prepare($query);
        $stm->bindValue(1, $id);

        $result = $stm->execute();
        $stm = null;  // Close statement

        return $result;
    }

    public function limit(int $count)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = PostgresGrammar::buildLimitQuery();
        $stm = self::$instance->prepare($query);

        $stm->bindValue(1, $count);
        $stm->execute();

        $result = $stm->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
        $stm = null; 

        return $result;
    }
    
    public function count($columns = '*', $filter = null)
    {
        if (self::$instance === null) {
            self::$instance = $this->connect();
        }

        $query = MySQLGrammar::buildCountQuery($columns);
        $stm = self::$instance->prepare($query);

        if ($filter) {
            $stm->bindValue(1, $filter[2]);
        }

        $stm->execute();
        $result = $stm->fetchColumn();
        $stm = null; 

        return $result;
    }
}