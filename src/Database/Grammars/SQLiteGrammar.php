<?php

namespace Proton\Database\Grammars;

use App\Models\Model;

class SQLiteGrammar
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

        $query = "INSERT INTO " . Model::getTableName() . 
                 " (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
        return $query;
    }

    public static function buildUpdateQuery($keys)
    {
        $setClause = implode(', ', array_map(fn($key) => "{$key} = ?", $keys));

        $query = "UPDATE " . Model::getTableName() . 
                 " SET {$setClause} WHERE ID = ?";
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