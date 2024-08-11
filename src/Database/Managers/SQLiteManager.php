<?php

namespace Proton\Database\Managers;

use Proton\Database\Grammars\SQLiteGrammar;
use Proton\Database\Managers\Contracts\DatabaseManager;
use App\Models\Model;

class SQLiteManager implements DatabaseManager
{
    protected static $instance;

    public function connect(): \PDO
    {
       if (!self::$instance) {
         self::$instance = new \PDO(env('DB_DRIVER') . ':' . database_path() . 'database.sqlite');
        }
      return self::$instance;
    }
    
  public function create($data) 
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }

    $query = SQLiteGrammar::buildInsertQuery(array_keys($data));
    $stm = self::$instance->prepare($query);
    
    for ($i=1; $i <= count($values = array_values($data)) ; $i++) { 
      $stm->bindValue($i, $values[$i - 1]);
    }

    return $stm->execute();
  }
  
  public function query(string $query, $values = [])
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }
      $stm = self::$instance->prepare($query);
      
      for ($i=1; $i <= count($values); $i++) {
        $stm->bindValue($i,$values[$i - 1]);
      }
  
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
       $stm->bindValue(1,$filter[2]);
     }
     $stm->execute();

     return $stm->fetchAll(\PDO::FETCH_CLASS,Model::getModel());
 }
  
  public function update($id, $data)
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }
    
     $query = SQLiteGrammar::buildUpdateQuery(array_keys($data));
     $stm = self::$instance->prepare($query);

     for ($i=1; $i <= count($values = array_values($data)); $i++) {
      $stm->bindValue($i,$values[$i - 1]);
      if ($i == count($values)) {
        $stm->bindValue($i+1, $id);
      }
    }

    return $stm->execute();
  }
  
  public function delete($id)
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }

    $query = SQLiteGrammar::buildDeleteQuery();

    $stm = self::$instance->prepare($query);

    $stm->bindValue(1,$id);
     
    return $stm->execute();
  }
  
  public function limite($count)
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }
     
     $query = SQLiteGrammar::buildLimiteQuery();
     $stm = self::$instance->prepare($query);
     
     $stm->bindValue(1,$count);
     $stm->execute();
     return $stm->fetchAll(\PDO::FETCH_CLASS,Model::getModel());
  }
  
  public function count($columns)
  {
    if (self::$instance === null) {
      self::$instance = $this->connect();
     }
     
     $query = SQLiteGrammar::buildCountQuery($columns);
     var_dump($query);
     $stm = self::$instance->prepare($query);
     $stm->bindValue(1,$columns);
     $stm->execute();
     return $stm->fetchColumn();
  }
  
  public function disconnect(): void
	{
		$this->connect = null;
	}
    
}