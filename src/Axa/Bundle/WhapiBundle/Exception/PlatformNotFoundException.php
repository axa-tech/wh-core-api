<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class PlatformNotFoundException extends \Exception
{
    public function __construct($platformId)
    {
        parent::__construct(sprintf("Platform '%d' not found", $platformId));
    }
}