<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class NotFoundEntityException extends \Exception
{
    public function __construct($entityName, $entityId)
    {
        parent::__construct(sprintf("%s '%d' not found", $entityName, $entityId));
    }
}