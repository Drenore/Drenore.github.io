<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="app_front")
     */
    public function index(): Response
    {   
        $manager = $this->getDoctrine()->getManager();
        if($this->getUser()){
            $candidature = $manager->getRepository(Candidat::class)->findBy(['iduser' => $this->getUser()]);
            return $this->render('front/index.html.twig', [
                'controller_name' => 'FrontController',
                'Candidatures' => $candidature
            ]);

        }
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/profile/candidater", name="candidater")
     */
    public function candidater(Request $request): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        
       

        if( $form->isSubmitted() && $form->isValid() ){
            $manager = $this->getDoctrine()->getManager();
            $candidat->setIduser($this->getUser());
            $manager->persist($candidat);
            $manager->flush();
            return $this->redirectToRoute('app_front');
        }

        return $this->render('front/formCandidat.html.twig', [
            'controller_name' => 'FrontController',
            'candidatForm' => $form->createView()

        ]);
    }

}
