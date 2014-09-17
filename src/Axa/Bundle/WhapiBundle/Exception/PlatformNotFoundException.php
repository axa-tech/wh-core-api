<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class PlatformNotFoundException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct("Platform '%s' not found", $message);
    }
}