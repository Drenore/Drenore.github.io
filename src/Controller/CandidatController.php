<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Form\SearchType;
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

class CandidatController extends AbstractController
{
    /**
     * @Route("/admin/candidat", name="app_candidat")
     */
    public function index(Request $request): Response
    {   
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        $manager = $this->getDoctrine()->getManager();
        $candidats = $manager->getRepository(Candidat::class)->findAll();
        $form2 = $this->createForm(SearchType::class);
        $form2->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($candidat);
            $manager->flush();
            return $this->redirectToRoute('app_candidat');
        }
        if($request->isMethod('POST')){
           
            $recherche = $form2->getData(); // $request->request->get('nameinput')  
            $search = $recherche['recherche'];
            $manager = $this->getDoctrine()->getManager();
            $candidats = $manager->getRepository(Candidat::class)->searchCandidat($search);
          
        }
    
        return $this->render('candidat/index.html.twig', [
            'controller_name' => 'CandidatController',
            'formCandidat' => $form->createView(),
            'formSearch' => $form2->createView(),
            'Candidats' => $candidats
        ]);
    }

    /**
     * @Route("/admin/SupprimerCandidat/{id}", name="sup_candidat")
     */

    public function supprimerCandidat($id){

        $manager = $this->getDoctrine()->getManager();
        $candidat = $manager->getRepository(Candidat::class)->find($id);
        $manager->remove($candidat);
        $manager->flush();
        return $this->redirectToRoute('app_candidat');
    }

     /**
     * @Route("/admin/afficherCandidat/{id}/{simulation}", name="show_candidat")
     */

    public function afficherCandidat($id,$simulation)
    {
        $manager = $this->getDoctrine()->getManager();
        $candidat = $manager->getRepository(Candidat::class)->find($id);
        $sujets = $manager->getRepository(Sujet::class)->simulateSujet($candidat);
        if(empty($candidat)){
            $candidat = NULL;
        }
        return $this->render('candidat/afficherCandidat.html.twig',
        [
            'controller_name' => 'CandidatController',  
            'candidat' => $candidat,
            'Sujets' => $sujets,  
            'simulation' => $simulation
                  
        ]);
    }

    /**
     * Affiche les informations d'un candidat 
     *  
     * Cette fonction   
     * 
     * @Route("/api/afficheCandidat/{id}", name="show_candida", methods={"GET"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Affiche les informations d'un candidat précis",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Candidat::class))
     *     )
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Ce champ réfère l'id du candidat recherché",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Tag(name="Candidat")
     * 
     */
    public function afficheCandidat($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $candidat = $manager->getRepository(Candidat::class)->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizer = $serializer->normalize($candidat);

        return new JsonResponse($normalizer);
        
    }
    
    /**
     * @Route("/admin/afficherCandidat/{id}/", name="show_candidat_simulation")
     */

    // public function afficherCandidat2($id)
    // {
    //     $manager = $this->getDoctrine()->getManager();
    //     $candidat = $manager->getRepository(Candidat::class)->find($id);
    //     $sujets = $manager->getRepository(Sujet::class)->simulateSujet($candidat);
    //     if(empty($candidat)){
    //         $candidat = NULL;
    //     }
    //     return $this->render('candidat/afficherCandidat.html.twig',
    //     [
    //         'controller_name' => 'CandidatController' 
    //         'candidat' => $candidat,
    //         'Sujets' => $sujets          
    //     ]);
    // }
    /**
     * @Route("/admin/ancrerCandidat/{idSujet}/{idCandidat}", name="ancrer_candidat")
     */
    public function ancrerSujetCandidat($idSujet, $idCandidat)
    {
        $manager = $this->getDoctrine()->getManager();
        $candidat = $manager->getRepository(Candidat::class)->find($idCandidat);
        $sujet = $manager->getRepository(Sujet::class)->find($idSujet);
        $candidat->setIdSujet($sujet);
        $manager->persist($candidat);
        $manager->flush();
        return $this->redirectToRoute('app_candidat');


    }

}
