<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class LogicException extends \LogicException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}