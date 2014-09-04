<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct(sprintf("User '%s' not found", $message));
    }
}