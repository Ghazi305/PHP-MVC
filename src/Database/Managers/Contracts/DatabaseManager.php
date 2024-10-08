<?php

namespace Proton\Database\Managers\Contracts;

interface DatabaseManager
{
    public function connect(): \PDO;
    
    public function disconnect(): void;
    
    public function query(string $query, $values = []);
    
    public function create($data);
   
    public function read($columns = '*', $filter = null);
    
    public function update($id,$data);
    
    public function delete($id);
    
    public function limit($count);
    
    public function count($columns);
}


