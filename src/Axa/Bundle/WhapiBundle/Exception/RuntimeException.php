<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class RuntimeException extends \RuntimeException
{
    public function __construct($message="An unexpected error occurs please try again or contact our support team !")
    {
        parent::__construct($message);
    }
}