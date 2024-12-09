<?php

namespace Proton\Support;

use Proton\Support\Arr;

class Config implements \ArrayAccess
{
    protected array $items = [];

    public function __construct($item)
    {
        if ($item instanceof \Generator) {
            $item = iterator_to_array($item);
        }

        foreach ($item as $key => $value) {
            $this->items[$key] = $value;
        }
    }

    /**
     * @param mixed $keys
     * @return bool
     */
    public function has($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (!Arr::exists($this->items, $key)) {
                    return false;
                }
            }
            return true;
        }
        return Arr::exists($this->items, $keys);
    }

    /**
     * @param string|array $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }

    /**
     * @param array $keys
     * @return array
     */
    public function getMany($keys)
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }
            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }

    /**
     *
     * @param string|array $key
     * @param mixed $value
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->items, $key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function push($key, $value)
    {
        $array = $this->get($key);

        if (!is_array($array)) {
            $array = [];
        }
        $array[] = $value;
        $this->set($key, $array);
    }

    /**
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        return Arr::exists($this->items, $key);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->exists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->set($offset, null);
    }
}