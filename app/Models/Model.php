<?php
 
namespace App\Models;

use Proton\Support\Str;

abstract class Model
{
    protected static $instance;
    
    public static function create(array $data)
    {
        self::$instance = static::class;
        
        return app()->db->create(self::getTableName(), $data);
    }
    
    public static function all($columns = '*')
    {
        self::$instance = static::class;
        
        return app()->db->read($columns);
    }
    
    public static function update($id, $data)
    {
        self::$instance = static::class;
        
        return app()->db->update($id, $data);
    }

    public static function delete($id)
    {
        self::$instance = static::class;
        
        return app()->db->delete($id);
    }

    public static function where($filter, $columns = '*')
    {
        self::$instance = static::class;
        
        return app()->db->read($columns, $filter);
    }
    
    public static function limit($count)
    {
        self::$instance = static::class;
        
        return app()->db->limit($count);
    }
    
    public static function count($columns = ['*'])
    {
        self::$instance = static::class;
        
        return app()->db->count($columns);
    }
     
    public static function with($relations, $columns = '*')
    {
        self::$instance = static::class;
        
        return app()->db->with($relations, $columns);
    }
    
    public static function getModel()
    {
        return self::$instance;
    }
    
    public static function getTableName()
    {
        return Str::lower(Str::plural(class_basename(self::$instance)));
    }
}