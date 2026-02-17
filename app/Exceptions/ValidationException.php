<?php

namespace App\Exceptions;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;

    public function throw($errors, $old)
    {
        $instance = new static;
        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }
}
