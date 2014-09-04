<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Axa\Bundle\WhapiBundle\Entity\Platform;
use Axa\Bundle\WhapiBundle\Entity\User;
use Axa\Bundle\WhapiBundle\Entity\Vm;
use Axa\Bundle\WhapiBundle\Entity\VmMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        $em = $this->getDoctrine()->getManager();
        $vmRepository = $em->getRepository('AxaWhapiBundle:Vm');
        $vm = $vmRepository->find(1);

        if(!$vm) {
            throw $this->createNotFoundException('VM not found');
        }

        /*$metadata = new VmMetadata();
        $metadata->setName('Memory');
        $metadata->setValue('5G');
        $metadata->setVm($vm);
        $em->persist($metadata);
        $em->flush();*/

        $metadata = $vm->getMetadataToArray();

        echo '<pre>';
        print_r($metadata);


        return $this->render('AxaWhapiBundle:Default:index.html.twig', array('name' => $name));
    }
}
