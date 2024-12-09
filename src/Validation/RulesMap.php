<?php

namespace Proton\Validation;

use Proton\Validation\Rules\RequiredRule;
use Proton\Validation\Rules\AlphaNumeircalRule;
use Proton\Validation\Rules\MaxRule;
use Proton\Validation\Rules\BetweenRule;
use Proton\Validation\Rules\EmailRule;
use Proton\Validation\Rules\ConfirmRule;
use Proton\Validation\Rules\UniqueRule; 
use Proton\Validation\Rules\StringRule;

class RulesMap 
{
    protected static array $map = [
        'required' => RequiredRule::class, 
        'alnum' => AlphaNumeircalRule::class,
        'max' => MaxRule::class, 
        'between' => BetweenRule::class,
        'email' => EmailRule::class, 
        'confirmed' => ConfirmRule::class,
        'string' => StringRule::class,
        'unique' => UniqueRule::class, 
    ];

    public static function resolve(string $rule, $options)
    {
        if (!isset(self::$map[$rule])) {
            throw new \Exception("Rule {$rule} not found.");
        }

        return new self::$map[$rule](...$options);
    }
}