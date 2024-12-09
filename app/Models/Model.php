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
        if (is_array($filter)) {
            $results = app()->db->read($columns, $filter);
            if (is_array($results) && count($results) > 0) {
                return $results[0];
            }
            return null;
        }
        
        $results = app()->db->read($columns, [$filter]);

        if (is_array($results) && count($results) > 0) {
            return $results[0];
        }

        return null;
    }

    public static function get($columns = '*', $filter = null)
    {
        self::$instance = static::class;

        $results = app()->db->read($columns, $filter);

        if (is_array($results) && count($results) > 0) {
            return $results;
        }

        return [];
    }

    public static function first()
    {
        $results = self::all();
        return is_array($results) && count($results) > 0 ? $results[0] : null;
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

    public static function with($relations, $columns = '*', $filter = null)
    {
        self::$instance = static::class;
        return app()->db->with($relations, $columns, $filter);
    }

    public function belongsTo($related, $foreignKey, $ownerKey)
    {
        return app()->db->belongsTo($related, $foreignKey, $ownerKey, self::getTableName());
    }

    public function hasMany($related, $foreignKey, $localKey)
    {
        return app()->db->hasMany($related, $foreignKey, $localKey, self::getTableName());
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