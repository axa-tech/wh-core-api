<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Axa\Bundle\WhapiBundle\Exception\OfferNotFoundException;

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApplicationController extends FOSRestController
{
    /**
     * Create a new Application
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Rest\View
     * @ApiDoc(
     *  description="Create a new Platform",
     *  requirements={
     *      {
     *          "name"="platform_id",
     *          "dataType"="int",
     *          "required"=true,
     *          "description"="The platform_id where to create the application"
     *      },
     *      {
     *          "name"="stack_id",
     *          "dataType"="int",
     *          "required"=true,
     *          "description"="The stackId of the application you want to create"
     *      },
     *      {
     *          "name"="name",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="The applications's name"
     *      },
     *      {
     *          "name"="topology",
     *          "dataType"="int",
     *          "required"=false,
     *          "description"="How many instance to create, default is 1"
     *      }
     *  },
     *  statusCodes={
     *         201="Returned when successful. Response will content a 'Location' header that point to the resource",
     *         404="When needed resource was not found",
     *         400="Returned when request was bad formatted",
     *         500="Unexpected server error"
     *     }
     * )
     */
    public function postAction(Request $request)
    {
        if (! $platform_id = $request->get('platform_id')) {
            return View::create("platform_id is required", 400);
        }

        if (! $stack_id = $request->get('stack_id')) {
            return View::create("stack_id is required", 400);
        }

        if (! $topology = $request->get('name')) {
            return View::create("name is required", 400);
        }

        if (! $topology = $request->get('topology')) {
            return View::create("topology is required", 400);
        }

        $manager = $this->getDoctrine()->getManager();

        if (! $platform = $manager->getRepository("AxaWhapiBundle:Platform")->find($platform_id)) {
            throw $this->createNotFoundException("Platform $platform_id does not exist");
        }

        if (! $stack = $manager->getRepository("AxaWhapiBundle:Stack")->find($stack_id)) {
            throw $this->createNotFoundException("Stack $stack_id does not exist");
        }

        try {
            $response = new Response();
            $response->setStatusCode(201);
            $response->headers->set('Location',
                $this->generateUrl(
                    'axa_whapi_platform_get', array('id' => $platform->getId()),
                    true
                )
            );

            return $response;

        } catch(OfferNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
