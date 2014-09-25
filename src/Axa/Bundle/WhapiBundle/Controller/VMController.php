<?php

namespace Axa\Bundle\WhapiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Controller\Annotations as Rest;


use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VMController extends FOSRestController
{
    /**
     * Update a vm
     * @Rest\View
     * @param $id
     * @param $request
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @ApiDoc(
     *  description="Update a vm",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="The vm id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when request was bad formatted",
     *         404="Returned when vm or other resource is not found ",
     *         500="Unexpected error"
     *     }
     * )
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $vm = $em->getRepository("AxaWhapiBundle:Vm")->find($id);

        if (!$vm) {
            throw new NotFoundHttpException(sprintf("VM %d was not found", $id));
        }

        $service = $this->get('axa_whapi.vm');
        $service->update($vm, $request->request->all());
        $response = new Response();
        $response->setStatusCode(204);

        return $response;
    }
}
