<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Form\SujetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
// use OpenApi\Annotations\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


class SujetController extends AbstractController
{
    /**
     * @Route("/admin/sujet", name="app_sujet")
     */
    public function index(Request $request): Response
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class,$sujet);
        $form->handleRequest($request);
        $manager = $this->getDoctrine()->getManager();
        $sujets = $manager->getRepository(Sujet::class)->findAll();

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($sujet);
            $manager->flush();
            return $this->redirectToRoute('app_sujet');
        }

        return $this->render('sujet/index.html.twig', [
            'controller_name' => 'SujetController',
            'formSujet' => $form->createView(),
            'Sujets' => $sujets
        ]);
    }

    /**
     * @Route("/api/suj", name="app_suj", methods={"POST","GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Ajouter un sujet",
     * )
     * 
     * @OA\Tag(name="Candidat")
     * 
     */
    public function index1()
    {  

        $manager = $this->getDoctrine()->getManager();
        $sujets = $manager->getRepository(Sujet::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = $serializer->normalize($sujets);

        return new JsonResponse($normalizer);
    
    }

     /**
     * @Route("/admin/supprimerSujet/{id}", name="sup_sujet")
     */

    public function supprimerSujet($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $candidat = $manager->getRepository(Sujet::class)->find($id);
        $manager->remove($candidat);
        $manager->flush();
        return $this->redirectToRoute('app_sujet');

    }

}
