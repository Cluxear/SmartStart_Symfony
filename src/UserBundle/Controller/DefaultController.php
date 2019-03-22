<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/anything")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
    /**
     * @Route("/register", name="register")
     *
     */
    public function getRegisterPage(){
        return $this->render('UserBundle:Default:base.html.twig');
    }
}
