<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlatformController extends Controller
{
    public function createAction()
    {
        $data = $this->getRequest()->request->all();
        //$platformService = $this->get('axa_whapi.platform');
        //$plaform = $platformService->create($data['userEmail'], $data['offerCode']);

        return new JsonResponse($data);


    }

}
