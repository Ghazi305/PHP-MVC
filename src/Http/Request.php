<?php

namespace Proton\Http;

use Proton\Support\Arr;

class Request 
{
    /**
     * Get the order method(GET, POST, PUT, DELETE).
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    
    /**
     */
    public function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        
        return $position === false ? $path : substr($path, 0, $position);
    }

    /**
     * return key request ( GET, POST, COOKIE).
     */
    public function all(): array
    {
        return $_REQUEST;
    }

    /**
     * @param array|string $keys .
     * @return array
     */
    public function only($keys): array
    {
        return Arr::only($this->all(), (array)$keys);
    }

    /**
     * @param string $key.
     * @return mixed
     */
    public function get(string $key)
    {
        return Arr::get($this->all(), $key);
    }
}