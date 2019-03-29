<?php

namespace CertificationBundle\Controller;

use CertificationBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/testslist")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $tests = $this->getDoctrine()->getManager()->getRepository(Test::class)->findTestsByUserId($user->getId());
        return $this->render('@Certification/Default/index.html.twig',array('test' => $tests['titre_test']));
    }
    /**
     * @Route("/test", name="test")
     */
    public function showTest(){
        return $this->render('@Certification/test.html.twig');
    }
}
