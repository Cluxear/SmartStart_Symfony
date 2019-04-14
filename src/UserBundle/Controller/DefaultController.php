<?php

namespace UserBundle\Controller;

use CertificationBundle\Entity\Notification;
use CertificationBundle\Entity\Test;
use CertificationBundle\Entity\UsersTests;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Tests\User\UserTest;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function homeAction(){
        $user = $this->getUser();
        $roles = $user->getRoles();
        $entityManager = $this->getDoctrine()->getManager();
        $notification = $entityManager->getRepository(Notification::class)->findBy(array('user_id'=> $user));

        if(in_array('ROLE_FREELANCER',$roles)){
            return $this->render("@FOSUser\Profile\dashboard_freelancer.html.twig",array('count'=> sizeof($notification),'notifications'=> $notification));
        }
        elseif (in_array('ROLE_TESTER',$roles)) {
            return $this->render("@FOSUser\Profile\dashboard_tester.html.twig");
        }
    }
    /**
     * @Route("/allSubmittedExams" , name="correct_exam")
     */
    public function testSubmitionsPage(){
        $UserTestAffectation = $this->getDoctrine()->getRepository(UsersTests::class)->findAll();
        return $this->render('@FOSUser/Profile/AllSubmittedTests.html.twig',['userstests'=> $UserTestAffectation]);

    }

    /**
     * @Route("/CorrectTest/{user_id}/{test_id}" , name="CorrectTest")
     * @param Request $request
     * @param $user_id
     * @param $test_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onCorrectTest( Request $request, $user_id, $test_id){

        /**
         * @var $UserSubmission UsersTests
         */

        $User = $this->getDoctrine()->getRepository(User::class)->find($user_id);
        $Test = $this->getDoctrine()->getRepository(Test::class)->find($test_id);
        // Error here, the server encountered an error preventing it from fulfilling the request.
        $UserSubmission = $this->getDoctrine()->getRepository(UsersTests::class)->findOneBy(array('user_id'=> $User,'test_id'=> $Test));

        $questions = $UserSubmission->gettest_id()->getquestions();
        $answers = $UserSubmission->getSubmition();

        $form = $this->createFormBuilder($UserSubmission)
            ->add('correction',CollectionType::class,[
                    'entry_type' => TextType::class,
                    'allow_add' => true,
                    'entry_options' => [
                        'attr' => ['placeholder' => 'question score', 'value'=> ''],
                    ],
                ]
            )
        ->add('save',SubmitType::class, ['label'=> 'Submit Correction','attr'=> array('class'=> 'btn btn-primary')])
            ->getForm();
        $form->handleRequest($request);
/*     if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entityManager = $this->getDoctrine()->getManager();
            /**
             * @var $submission UsersTests
             */
         /*   $submission = $form->getData();
            $submission->setNbrEssai($submission->getnbr_essai() + 1);

            $submission->setStatus('');
            $entityManager->merge($submission);
            $entityManager->flush();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $notification = new Notification();
            $notification->setUserId($user_id);
            $notification->setMessage("Vous avez recu une notification");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification);
            $entityManager->flush();
            return $this->redirectToRoute('submitted_test', array('test_id' => $test_id));
        }*/
        return $this->render('@FOSUser/Profile/correct_test.html.twig',['User'=> $User,'Test'=> $Test, 'answers'=> $answers, 'questions'=> $questions, 'form' => $form->createView() ]);

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
