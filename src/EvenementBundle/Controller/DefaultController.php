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
        return $this->render('@Evenement/AjouterEvenement.html.twig', array('form'=> $form->createView()));
    }
}
