<?php

namespace Axa\Bundle\WhsysBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AxaWhsysBundle:Default:index.html.twig', array('name' => $name));
    }
}
