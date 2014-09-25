<?php

namespace Axa\Bundle\WhapiBundle\Utility;


trait Request {

    public function sanitizeData(array $data)
    {
        if(isset($data['id'])) {
            unset($data['id']);
        }

        if(isset($data['_format'])) {
            unset($data['_format']);
        }

        return $data;
    }
} 