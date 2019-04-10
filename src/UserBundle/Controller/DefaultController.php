<?php

namespace UserBundle\Controller;

use CertificationBundle\Entity\UsersTests;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\User;

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
/**
 * @Route("/freelancerDashboard/tests", name="freelancer_tests")
 */
    public function displayTestSubmissionStatusForUser(){
        $user = $this->getUser();
        $UserTestAffectation = $this->getDoctrine()->getRepository(UsersTests::class)->findBy(['user_id' => $user]);
        $tests = array();
        /**
         * @var $uta UsersTests
         *
         */
        foreach( $UserTestAffectation as $uta){
            $tests[] = $this->getDoctrine()->getRepository(\CertificationBundle\Entity\Test::class)->findOneBy(['id_test' => $uta->gettest_id()]);
        }
        return $this->render('@FOSUser/Profile/userSubmittedTests.html.twig', array('UserTests'=> $UserTestAffectation,'tests'=>$tests));
    }
}
