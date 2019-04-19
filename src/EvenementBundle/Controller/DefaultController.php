<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function renderEventAction($eventId)
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($eventId);
        return $this->render('@Evenement/AfficherEvenement.html.twig', array('evenement' => $evenement));
    }

}
