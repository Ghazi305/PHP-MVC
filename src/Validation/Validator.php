<?php

namespace Proton\Validation;

use Proton\Validation\ErrorBag;
use Proton\Validation\Message;
use Proton\Validation\RulesMap;
use Proton\Validation\Resolver;
use Proton\Validation\Rules\Contract\Rule;

class Validator 
{
  protected array $data = [];
  protected array $rules = [];
  protected array $aliases = [];
  protected ErrorBag $errorBag;

  /**
   * Initialize the validator with the provided data.
   * 
   * @param array $data The data to be validated.
   */ 
  public static function make($data) // دالة ثابتة
  {
    $instance = new self(); // إنشاء كائن جديد
    $instance->data = $data;
    $instance->errorBag = new ErrorBag();
    $instance->validate();
    return $instance;
  }

  /**
   * Validate the provided data based on the set rules.
   */
  protected function validate()
  {
    // Iterate through each rule and apply it to the data
    foreach ($this->rules as $field => $rules)
    {
      foreach (Resolver::make($rules) as $rule) {
        // Apply the rule to the field
        return $this->applyRule($field, $rule);
      }
    }
  }

  /**
   * Apply a single validation rule to the specified field.
   * 
   * @param string $field The field to validate.
   * @param Rule $rule The rule to apply to the field.
   */
  public function applyRule($field, Rule $rule)
  {
    // If the rule fails, add the error message to the error bag
    if (!$rule->apply($field, $this->getFieldValue($field), $this->data)){
      $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
    }
  }

  /**
   * Retrieve the value of a specific field from the data.
   * 
   * @param string $field The field whose value to retrieve.
   * @return mixed The value of the field.
   */
  public function getFieldValue($field)
  {
    return $this->data[$field] ?? null;
  }

  /**
   * Set the validation rules for the fields.
   * 
   * @param array $rules The validation rules.
   */
  public function setRules($rules)
  {
    $this->rules = $rules;
  }

  /**
   * Check if the data passes the validation.
   * 
   * @return bool True if validation passes, false otherwise.
   */
  public function passes()
  {
    return empty($this->errors());
  }

  /**
   * Retrieve the validation errors.
   * 
   * @param string|null $key The specific field's errors or null to get all errors.
   * @return array The validation errors.
   */
  public function errors($key = null)
  {
    return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
  }

  /**
   * Get the alias for a field if defined, or return the field name.
   * 
   * @param string $field The field to get the alias for.
   * @return string The alias or the field name.
   */
  public function alias($field)
  {
    return $this->aliases[$field] ?? $field;
  }

  /**
   * Set the aliases for the fields.
   * 
   * @param array $aliases The aliases for the fields.
   */
  public function setAliases(array $aliases)
  {
    $this->aliases = $aliases;
  }
}