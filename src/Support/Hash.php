<?php

namespace Proton\Support;

class Hash
{
    /**
     * @param string $value
     * @return string
     */
    public static function password($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }
    
    /**
     * @param string $value
     * @return string
     */
    public static function make($value)
    {
      return password_hash($value, PASSWORD_BCRYPT); 
    }
    
    /**
     * @param string $value
     * @param string $hashValue
     * @return bool
     */
    public static function verify($value, $hashValue)
    {
        return password_verify($value, $hashValue);
    }

    /**
     * @param string $value
     * @param string $hashValue
     * @return bool
     */
    public static function verifyStrong($value, $hashValue)
    {
        return password_verify($value, $hashValue);
    }
}