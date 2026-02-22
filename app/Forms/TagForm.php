<?php

namespace App\Forms;

use App\Exceptions\ValidationException;
use Core\Validator;

class TagForm extends Validator
{
    protected $errors;
    public $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;

        if (!Validator::string($attributes['name'], 1, 100)) {
            $this->errors['name'] = 'Name must be a string between 1 and 100 characters.';
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->isValid() ? $instance : $instance->throwIfNotValid();
    }

    public function throwIfNotValid()
    {
        if (!$this->isValid()) {
            throw (new ValidationException)->throw($this->getErrors(), $this->attributes);
        }
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }
}
