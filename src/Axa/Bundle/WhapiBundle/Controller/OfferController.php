<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Axa\Bundle\WhapiBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $offers = $em->getRepository("AxaWhapiBundle:Offer")->findAll();
        $data = array();
        foreach($offers as $offer) {
            $data[] = $offer->toArray();
        }
        return new JsonResponse($data);
    }

}
