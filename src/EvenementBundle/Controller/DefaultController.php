<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Participation;
use EvenementBundle\Form\EvenementType;
use EvenementBundle\Form\ParticipationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use EvenementBundle\Service\FileUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactory;

class DefaultController extends Controller
{
    /**
     * @Route("/ajouter_evenement", name="ajouter_evenement")
     */
    public function addEventAction(Request $request)
    {
        $evenement = new Evenement();

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            /**
             * @var $submissions Evenement
             */
            $submissions = $form->getData();
            $submissions->setUserId($this->getUser());
            $entityManager->persist($submissions);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('@Evenement/AjouterEvenement.html.twig', array('form'=> $form->createView()));
    }
    /**
     * @Route("/evenements_list", name="evenements_list")
     */
    public function listEventsAction()
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('@Evenement/EvenementsList.html.twig', array('eventsList' => $evenements));
    }
    /**
     * @Route("/afficher_evenement{eventId}", name="afficher_evenement")
     */
    public function renderEventAction($eventId, Request $request)
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($eventId);

        $participation = new Participation();

        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            /**
             * @var $submissions Participation
             */
            $submissions = $form->getData();

            //$file = $submissions->getFichier();
            //$fileName = $fileUploader->upload($file);
            //$submissions->setBrochure($fileName);

            $submissions->setUserId($this->getUser());
            $entityManager->persist($submissions);
            $entityManager->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('@Evenement/AfficherEvenement.html.twig', array('evenement' => $evenement, 'form'=> $form->createView()));
    }



}
