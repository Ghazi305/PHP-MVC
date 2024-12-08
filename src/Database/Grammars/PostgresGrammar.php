<?php

namespace Proton\Database\Grammars;

use App\Models\Model;

class PostgresGrammar 
{
    public static function buildSelectQuery($columns = '*', $filter = null)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT {$columns} FROM " . Model::getTableName();

        if ($filter) {
            $query .= " WHERE {$filter[0]} {$filter[1]} ?";
        }

        return $query;
    }

    public static function buildInsertQuery($keys)
    {
        $values = implode(', ', array_fill(0, count($keys), '?'));

        $query = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            Model::getTableName(),
            implode(', ', $keys),
            $values
        );

        return $query;
    }

    public static function buildUpdateQuery($keys)
    {
        $setClause = implode(', ', array_map(fn($key) => "{$key} = ?", $keys));

        $query = "UPDATE " . Model::getTableName() . " SET {$setClause} WHERE ID = ?";
        return $query;
    }

    public static function buildDeleteQuery()
    {
        return "DELETE FROM " . Model::getTableName() . " WHERE ID = ?";
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