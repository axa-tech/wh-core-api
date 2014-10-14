<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class OutOfMemoryException extends LogicException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}