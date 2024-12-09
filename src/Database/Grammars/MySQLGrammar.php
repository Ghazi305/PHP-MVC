<?php

namespace Proton\Database\Grammars;

use App\Models\Model;

class MySQLGrammar
{
    public static function buildSelectQuery($columns = '*', $filter = null, $limit = null, $orderBy = null)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT {$columns} FROM " . Model::getTableName();

        if ($filter && is_array($filter) && count($filter) >= 2) {
            $query .= " WHERE {$filter[0]} {$filter[1]} ?";
        }

        if ($orderBy) {
            $query .= " ORDER BY {$orderBy}";
        }

        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        return $query;
    }

    public static function buildInsertQuery($keys, $records)
    {
        if (empty($keys) || empty($records)) {
            throw new \InvalidArgumentException("Keys and records cannot be empty for insert query");
        }

        $values = implode(', ', array_fill(0, count($keys), '?'));

        $query = "INSERT INTO " . Model::getTableName() . 
                 " (`" . implode('`, `', $keys) . "`) VALUES ";

        $placeholders = [];
        foreach ($records as $record) {
            $placeholders[] = '(' . implode(', ', array_fill(0, count($record), '?')) . ')';
        }
        $query .= implode(', ', $placeholders);

        return $query;
    }

    public static function buildUpdateQuery($keys, $where = null)
    {
        if (empty($keys)) {
            throw new \InvalidArgumentException("Keys cannot be empty for update query");
        }

        $setClause = implode(', ', array_map(fn($key) => "{$key} = ?", $keys));

        $query = "UPDATE " . Model::getTableName() . 
                 " SET {$setClause}";

        if ($where) {
            $query .= " WHERE {$where}";
        }

        return $query;
    }

    public static function buildDeleteQuery($where = null)
    {
        $tableName = Model::getTableName();
        if (!$tableName) {
            throw new \RuntimeException("Table name not defined");
        }

        $query = "DELETE FROM {$tableName}";

        if ($where) {
            $query .= " WHERE {$where}";
        }

        return $query;
    }

    public static function buildLimitQuery()
    {
        return "SELECT * FROM " . Model::getTableName() . " LIMIT ?";
    }

    public static function buildCountQuery()
    {
        return "SELECT COUNT(*) FROM " . Model::getTableName();
    }
}
 