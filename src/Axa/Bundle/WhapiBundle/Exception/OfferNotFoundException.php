<?php

namespace Axa\Bundle\WhapiBundle\Exception;

class OfferNotFoundException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct(sprintf("Offer '%s' not found", $message));
    }
}