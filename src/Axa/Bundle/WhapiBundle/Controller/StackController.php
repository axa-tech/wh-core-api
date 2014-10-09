<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\View\View,
    FOS\RestBundle\Controller\Annotations as Rest;


use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class StackController extends FOSRestController
{
    /**
     * List all stacks
     * @Rest\View
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Axa\Bundle\WhapiBundle\Exception\RuntimeException;
     * @ApiDoc(
     *  description="Get all stacks",
     *
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when request was bad formatted",
     *         500="Unexpected error"
     *     }
     * )
     */
    public function getAllAction()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * returns StackRepository
     *
     * @return \Axa\Bundle\WhapiBundle\Entity\StackRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository("AxaWhapiBundle:Stack");
    }

}
