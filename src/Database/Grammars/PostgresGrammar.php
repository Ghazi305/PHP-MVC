<?php

namespace Proton\Database\Grammars;

use App\Models\Model;

class PostgresGrammar 
{
  public static function buildSelectQuery($columns = '*',$filter = null)
  {
    if (is_array($columns)) {
      $columns = implode(', ', $columns);
    }

    $query = "SELECT {$columns} FROM " . Model::getTableName();

    if ($filter) {
      $query .= " WHERE {$filter[0]}{$filter[1]} ?";
    }

    return $query;
  }
  
  public static function buildInsertQuery($keys)
  {
    $values = '';
    for ($i = 1; $i <= count($keys); $i++) { 
      $values .= '?';
      if ($i < count($keys)) {
        $values .= ', ';
      }
    }
    
    $query = "INSERT INTO " . Model::getTableName() . ' (`' . implode('`, `',$keys) . '`) VALUES(' . rtrim($values, ', ' ) . ')';
    return $query;
  }
  
  public static function buildUpdateQuery($keys)
  {
    $query = "UPDATE " . Model::getTableName() . ' SET ';

    foreach ($keys as $key) {
      $query .= "{$key} = ?, "; 
    }

    $query = rtrim($query, ', ') . ' WHERE ID = ?';
    return $query;
  }
  
  public static function buildDeleteQuery()
  {
    return "DELETE FROM " . Model::getTableName() . ' WHERE ID = ?';
  }
  
  public static function buildlimitQuery()
    {
      return "SELECT * FROM " . Model::getTableName() . ' LIMIT ? ';
    }
    
    public static function buildCountQuery()
    {
      
    }
}