<?php

namespace Axa\Bundle\WhapiBundle\Controller;

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

class VmQueueController extends FOSRestController
{
    /**
     * Get the vm's queue name.
     * @Rest\View
     * @param $ip
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Axa\Bundle\WhapiBundle\Exception\RuntimeException;
     * @ApiDoc(
     *  description="Get the vm's queue name. If queue doesn't exist it is created",
     *  requirements={
     *      {
     *          "name"="ip",
     *          "dataType"="string",
     *          "description"="The vm's IP"
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
    public function getAction($ip)
    {
        $vm = $this->getRepository()->findOneBy(array("ip"=>$ip));

        if (!$vm) {
            throw $this->createNotFoundException(sprintf("Vm with Ip %s does not exist", $ip));
        }

        if (! $queue = $vm->getQueue()) {
            $this->get('axa_whapi.vm')->createQueue($vm);
        }

        return array(
            "vmIp"      => $vm->getIp(),
            "vmId"      => $vm->getRemoteId(),
            "vmQueue"   => $vm->getQueue()->getName()
        );
    }

    /**
     * Get the vm repository
     *
     * @return \Axa\Bundle\WhapiBundle\Entity\VmRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository("AxaWhapiBundle:Vm");
    }

}
