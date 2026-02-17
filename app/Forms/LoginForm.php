<?php

namespace App\Forms;

use App\Exceptions\ValidationException;
use Core\Validator;

class LoginForm extends Validator
{
    protected $errors;
    public $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;

        if (!Validator::string($attributes['password'], 8, 255)) {
            $this->errors['password'] = 'Password must be between 8 and 255 characters.';
        }

        if (!Validator::email($attributes['email'])) {
            $this->errors['email'] = 'Invalid email address.';
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
