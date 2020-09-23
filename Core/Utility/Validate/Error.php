<?php

namespace Core\Utility\Validate;


class Error
{
    private $error;

    function __construct(array $error)
    {
        $this->error = $error;
    }

    function first()
    {
        return array_shift($this->error);
    }

    function all()
    {
        return $this->error;
    }
}