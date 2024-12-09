<?php

namespace Proton\Validation\Rules;

use Proton\Validation\Rules\Contract\Rule;
 
class StringRule implements Rule
{
  public function apply($field, $value, $data = [])
  {
    return is_string($value);
  }

  public function __toString()
  {
    return '%s must be a string';
  }
}
 