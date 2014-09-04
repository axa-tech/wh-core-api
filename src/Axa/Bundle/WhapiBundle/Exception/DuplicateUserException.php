<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class DuplicateUserException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct(sprintf("User '%s' already exists", $message));
    }
}