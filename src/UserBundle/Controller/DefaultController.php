<?php

namespace UserBundle\Controller;

use http\Env\Request;
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
     * @Route("/dashboard", name="dashboard")
     */
    public function homeAction(){
        $user = $this->getUser();
        $roles = $user->getRoles();
        if(in_array('ROLE_FREELANCER',$roles)){

            return $this->render("@FOSUser\Profile\dashboard_freelancer.html.twig");
        }
        else {
            return $this->render("@FOSUser\Profile\dashboard.html.twig");
        }
    }

}
