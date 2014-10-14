<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class OutOfPortLimitException extends LogicException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}