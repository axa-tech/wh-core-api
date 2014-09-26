<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class EntityNotFoundException extends \Exception
{
    public function __construct($entityName, $entityId)
    {
        parent::__construct(sprintf("%s '%d' not found", $entityName, $entityId));
    }
}