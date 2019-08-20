<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compts;
use App\Entity\Depots;
use App\Form\ComptType;
use App\Form\DepotType;
use App\Entity\Partenaire;
use App\Form\BlocPartType;
use App\Repository\UserRepository;
use App\Repository\DepotsRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/api")
 */

class PartenaireController extends AbstractController
{
    /**
     * @Route("/partenaire", name="partenaire")
     */
    public function index()
    {
        return $this->render('partenaire/index.html.twig', [
            'controller_name' => 'PartenaireController',
        ]);
    }

   
    /**
     * @Route("/ajoutcompt", name="compt")
     * @IsGranted("ROLE_SUPERADMIN")
     
     */

    //-----------AjoutCompt--------------///////////
    public function ajoutcompt(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator) 
    {          

          $compt = new Compts();
          $form = $this->createForm(ComptType::class, $compt);
        $form->handleRequest($request);
        $values=$request->request->all();
        $form->submit($values);
     // Enregistrons les informations de date dans des variables

        $jours = date('d');
        $mois = date('m');
        $annee = date('Y');

         $heure = date('H');
         $minute = date('i');
         $seconde= date('s');
       $test = $jours.$mois.$annee.$heure.$minute.$seconde;
          $compt->setNumcompt($test);
          $compt->setSolde(0);

          $repo=$this->getDoctrine()->getRepository(Partenaire::class);
          $partenaires=$repo->find($values['partenaire']);
         

          $compt->setPartenaire($partenaires);
         

          $entityManager = $this->getDoctrine()->getManager();

          $entityManager->persist($compt);
          $entityManager->flush();
          $data = [
            'statu' => 201,
            'messages' => 'compte creer'
        ];

        return new JsonResponse($data, 201);

    }

  //---------------Faire un dépots--------------------//////

    /**
     * @Route("/depot", name="depot", methods={"POST"})
     * @IsGranted("ROLE_CAISSIER")
     */
public function depot(Request $request,EntityManagerInterface $entityManager,DepotsRepository $repo ): Response
    {

        $depot = new Depots();
        $form = $this->createForm(DepotType::class, $depot);
        $form->handleRequest($request);
        $values=$request->request->all();
        $form->submit($values);

        $depot->setDateDepot(new \DateTime());

        if($values['montant']>=75000){

         $depot->setMontant($values['montant']);
         $repo=$this->getDoctrine()->getRepository(Compts::class);

        $compt=$repo->find($values['compt']);
        
        $compt->setSolde($compt->getSolde()+$depot->getMontant());

        $depot->setCompt($compt);

   
        $user=$this->getUser();

        $depot->setCaissier($user);
         
        $depot->setSoldeInitial($compt->getSolde());


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($depot);
            $entityManager->persist($compt);

            $entityManager->flush();
        return new Response('Le depot effectuer',Response::HTTP_CREATED);

        }
        else{
            return new Response('veillez saisir un montant superieur ou egal a 75000',Response::HTTP_CREATED);
        }
            
    } 
    //---------Bloquer Debloquer partenaire----------///

/**
 * @Route("/partbloquer/{id}", name="partBlock", methods={"PUT"})
 * @IsGranted("ROLE_SUPERADMIN")

 */

public function partBloquer(Request $request, UserRepository $userRepo,EntityManagerInterface $entityManager,User $user): Response
    {

        $values=$request->request->all();//si form
        $part = new Partenaire();
        $form = $this->createForm(BlocPartType::class, $part);
        $form->handleRequest($request);
         
        $form->submit($values);


        $part = $entityManager->getRepository(Partenaire::class)->find($user->getId());        

        if($part->getStatus()=="Active"){
            $part->setStatus("bloquer");
            $entityManager->flush();
            $data = [
                'status' => 200,
                'message' => 'partenaire bloquer'
            ];
            return new JsonResponse($data);
        }
        else{
            $part->setStatus("Active");
            $entityManager->flush();
            $data = [
                'status' => 200,
                'message' => 'partenaire debloquer'
            ];
            return new JsonResponse($data);
        }
    }





}
