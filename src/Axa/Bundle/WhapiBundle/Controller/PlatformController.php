<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Axa\Bundle\WhapiBundle\Exception\OfferNotFoundException;

use Axa\Bundle\WhapiBundle\Exception\PlatformNotFoundException;
use Axa\Bundle\WhapiBundle\Exception\RuntimeException;
use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlatformController extends FOSRestController
{
    /**
     * Create a new Platform
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @Rest\View
     * @ApiDoc(
     *  description="Create a new Platform",
     *  requirements={
     *      {
     *          "name"="userEmail",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="The user email for who to create the platform"
     *      },
     *      {
     *          "name"="offerCode",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="The offer code. Accepted value [SP, MP, LP]"
     *      }
     *  },
     *  statusCodes={
     *         201="Returned when successful. Response will content a 'Location' header that point to the resource",
     *         400="Returned when request was bad formatted",
     *         500="Unexpected error"
     *     }
     * )
     */
    public function postAction(Request $request)
    {
        if (! $userEmail = $request->get('userEmail')) {
            return View::create("userEmail is required", 400);
        }

        if (! $offerCode = $request->get('offerCode')) {
            return View::create("offerCode is required", 400);
        }

        if (! $platformName = $request->get('name')) {
            return View::create("name is required", 400);
        }

        try {
            $platformService = $this->get('axa_whapi.platform');
            $platform = $platformService->create($userEmail, $offerCode, $platformName);
            $amqpMessage = $platformService->getAmqpCreateMessage($platform);
            $createPlatformProducer = $this->get('old_sound_rabbit_mq.create_platform_producer');
            $createPlatformProducer->setContentType('application/json');
            $createPlatformProducer->publish(json_encode($amqpMessage));

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


    /**
     * Get a platform by it id
     * @Rest\View
     * @param $id
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Axa\Bundle\WhapiBundle\Exception\RuntimeException;
     * @ApiDoc(
     *  description="Get a Platform by it id",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="The platform id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when request was bad formatted",
     *         404="Returned when platform or other resource is not found ",
     *         500="Unexpected error"
     *     }
     * )
     */
    public function getAction($id)
    {
        try {
            return $this->get('axa_whapi.platform')->find($id);

        } catch(PlatformNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch(\Exception $e) {
            throw new RuntimeException();
        }
    }

    /**
     * Update a platform
     * @Rest\View
     * @param $id
     * @param $request
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @ApiDoc(
     *  description="Update a platform",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="The platform id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when request was bad formatted",
     *         404="Returned when platform or other resource is not found ",
     *         500="Unexpected error"
     *     }
     * )
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $platform = $em->getRepository("AxaWhapiBundle:Platform")->find($id);

        if (!$platform) {
            throw new NotFoundHttpException(sprintf("Platform %d was not found", $id));
        }

        $service = $this->get('axa_whapi.platform');
        $service->update($platform, $request->request->all());

        $response = new JsonResponse();
        $response->setStatusCode(204);

        return $response;
    }
}
