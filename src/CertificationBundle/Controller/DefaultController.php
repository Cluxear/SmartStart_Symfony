<?php

namespace CertificationBundle\Controller;

use CertificationBundle\Entity\Notification;
use CertificationBundle\Entity\Test;
use CertificationBundle\Entity\UsersTests;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/testslist")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $testsForUser = $this->getDoctrine()->getManager()->getRepository(Test::class)->findTestsByUserIdWhereStatusIsActive($user->getId());
        if(!empty($testsForUser)){

            $trialsLeft = $this->getDoctrine()->getManager()->getRepository(UsersTests::class)->getNbrEssaieAndIdTest($user->getId());
            /**
             * @var $paginator \Knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $testsForUser,
                $request->query->getInt('page', 1),
                5
            );
            return $this->render('@Certification/testslist.html.twig',array('tests' => $result, 'trials'  => $trialsLeft ));
        }

        return $this->render('@Certification/testslist.html.twig');
    }

    /**
     * @Route("/exam_page/{id}", name="exam_page")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderExam($id, Request $request){
        /**
         * @var $test Test
         */
        $user = $this->getUser();
        $test = $this->getDoctrine()->getRepository(Test::class)->find($id);
        /**
         * @var $UserTestAffectation UsersTests
         */
        $UserTestAffectation = $this->getDoctrine()->getRepository(UsersTests::class)->findOneBy(['test_id'=>$test,'user_id'=> $user]);
        $questions = $test->getquestions();
        $form = $this->createFormBuilder($UserTestAffectation)
            ->add('submition',CollectionType::class,[
               'entry_type' => IntegerType::class,
                    'allow_add' => true,
                    'entry_options' => [
                        'attr' => ['size'=> 10],
                    ],
                    ]
            )
            ->add('save',SubmitType::class, ['label'=> 'Submit Test','attr'=> array('class'=> 'btn btn-primary')])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $entityManager = $this->getDoctrine()->getManager();
            /**
             * @var $submissions UsersTests
             */
            $submissions = $form->getData();
            $submissions->setNbrEssai($submissions->getnbr_essai()+1);
            $submissions->setStatus('submitted');
            $entityManager->merge($submissions);
            $entityManager->flush();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('submitted_test',array('test_id'=> $test->getid_test()));
        }
        return $this->render('@Certification/examPage.html.twig',array('questions'=> $questions, 'form'=> $form->createView()));
    }
    /**
     * @Route("/SubmittedTest/{test_id}", name="submitted_test")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function TestsubmitionPage($test_id){
        return $this->render('@Certification/successfulTestSubmission.html.twig');

    }
    /**
     * @Route("/CheckSubmittedTest/{test_id}", name="check_submitted_test")
     */
    public function CheckTestSubmitionPage($test_id){
        return $this->render('@Certification/check_submitted_test.html.twig');

    }

}
