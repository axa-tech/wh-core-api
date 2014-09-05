<?php

namespace Axa\Bundle\WhapiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AxaWhapiBundle:Default:index.html.twig', array('name' => $name));
    }
}
