<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compts;
use App\Form\UserType;
use App\Form\ComptType;
use App\Form\LoginType;
use App\Form\BloquerType;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


   /**
    * @Route("/api")
   */
class SecurityController extends AbstractController

{

    /**
     * @Route("/security", name="security")
     */


    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    private $passwordEncoder;

public function __construct(UserPasswordEncoderInterface $passwordEncoder)
{
  $this->passwordEncoder = $passwordEncoder;
}
    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request, JWTEncoderInterface $JWTEncoder)
    {
       
    $user =  new User();
    $values=$request->request->all();//si form
    $form = $this->createForm(LoginType::class, $user);
    $form->handleRequest($request);
    $form->submit($values);
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
        'username' =>$values["username"]
    ]);

    if (!$user) {
        throw $this->createNotFoundException('User Not Found');
    }
    $isValid = $this->passwordEncoder->isPasswordValid($user, $values["password"]);
    if(!$isValid){ 
     throw $this->createNotFoundException('Password incorrect');

    }
    if($user->getStatus()=="bloquer"){
        throw $this->createNotFoundException('Acces refuser! Veillez contacter l admin');

    }
    if($user->getPartenaire()->getStatus()=="bloquer"){
        throw $this->createNotFoundException('Acces refuser! Veillez contacter l superadmin');

    }
    $token = $JWTEncoder->encode([
            'username' => $user->getUsername(),
            'exp' => time() + 3600 // 1 hour expiration
        ]);

    return new JsonResponse(['token' => $token]);


         var_dump($values);die();
        
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @IsGranted("ROLE_SUPERADMIN")

     */

    //-------Ajout d'un SupertUser et Caissier----/////
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $values=$request->request->all();//si form
        $file=$request->files->all()['imageName'];
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       
        $form->submit($values);
     
        if ($form->isSubmitted() && $form->isValid()) {
        
         $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()
            )
        );           
            if ($values['profil']==1) {
                $user->setRoles(['ROLE_SUPERADMIN']);    
            }
           
            if ($values['profil']==2) {
                $user->setRoles(['ROLE_CAISSIER']);    
            }
            $user->setImageFile($file);  
            $user->setUpdatedAt(new \DateTime()) ; 
            $user->setStatus('Active');

            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'L\'utilisateur ajouter'
            ];

            return new JsonResponse($data, 201);
        }
        return new Response($validator->validate($form));
    }
    /**
     * @Route("/ajoutpart", name="ajoutpart", methods={"POST"}) 
     * @IsGranted("ROLE_SUPERADMIN")

     */
     
     //-------Ajout d'un Partenaire et son Admin et Compt ----/////
     public function ajoutpart(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager , ValidatorInterface $validator)
     {
         $values=$request->request->all();//si form
 
         $file=$request->files->all()['imageName'];
 
         $part = new Partenaire();
 
         $form=$this->createForm(PartenaireType::class, $part);
 
         $form->handleRequest($request);
        
         $form->submit($values);
 
          $part->setStatus('Active');
           
          $compt = new Compts();
 
          // Enregistrons les informations de date dans des variables
          $form=$this->createForm(ComptType::class, $compt);
          $form->handleRequest($request);
         
          $form->submit($values);
                  $jours = date('d');
                  $mois = date('m');
                  $annee = date('Y');
          
                 $heure = date('H');
                 $minute = date('i');
                 $seconde= date('s');
      $test = $jours.$mois.$annee.$heure.$minute.$seconde;
          $compt->setNumcompt($test);
          $compt->setPartenaire($part);
          $compt->setSolde(0);
 
 
          $user = new User();
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);
                   
         $form->submit($values);
                 
          $user->setPassword($passwordEncoder->encodePassword($user,
             $form->get('password')->getData())); 
 
          if ($values['profil']==3) {
              $user->setRoles(['ROLE_ADMIN']);    
                      }
                       
         if ($values['profil']==4) {
             $user->setRoles(['ROLE_USER']);    
                   }
             $user->setUpdatedAt(new \DateTime()) ; 
             $user->setStatus('Active');
                  
             $user->setImageFile($file); 
             $user->setStatus('Active');
             $user->setPartenaire($part);
             $user->setNumcompt($compt);
            
             $entityManager = $this->getDoctrine()->getManager();
 
             $entityManager->persist($user);
             $entityManager->persist($part);
             $entityManager->persist($compt);
             $entityManager->flush();
     
             $data = [
                 'statu' => 201,
                 'messages' => 'Le partenaire ajouter'
             ];
 
             return new JsonResponse($data, 201);

             return new Response($validator->validate($form));
 
            }
    /**
     * @Route("/ajoutpartuser", name="ajoutpartuser", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     
     */
     //-------Ajout des users d'un partenaire  ----/////
    public function ajoutpartuser(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
    
     $values=$request->request->all();//si form
     $file=$request->files->all()['imageName'];
     $user = new User();
     $form = $this->createForm(UserType::class, $user);
     $form->handleRequest($request);
      
     $form->submit($values);
    
       if ($form->isSubmitted()) {
       
        $user->setPassword(
           $passwordEncoder->encodePassword(
               $user,
               $form->get('password')->getData()
           )
       );           
    if ($values['profil']==3) {
        $user->setRoles(['ROLE_ADMIN']);    
                }
                 
   if ($values['profil']==4) {
       $user->setRoles(['ROLE_USER']);    
             }

             $partenaire=$this->getUser()->getPartenaire();

            $user->setPartenaire($partenaire);
            $user->setStatus('Active');
            $user->setImageFile($file);

            $user->setUpdatedAt(new \DateTime()) ;

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();
            $data = [
                'statu' => 201,
                'messages' => 'Lutilisateur ajouter'
            ];

            return new JsonResponse($data, 201);
   }
   return new Response($validator->validate($form));

}
//-------Bloquer Debloquer-----------------/////

/**
 * @Route("/bloquer", name="userBlock", methods={"GET","POST"})
 * @IsGranted("ROLE_ADMIN")

 */

public function userBloquer(Request $request, UserRepository $userRepo,EntityManagerInterface $entityManager): Response
    {

        $values=$request->request->all();//si form
        $user = new User();
        $form = $this->createForm(BloquerType::class, $user);
        $form->handleRequest($request);
         
        $form->submit($values);


        $user=$userRepo->findOneByUsername($values['username']);
        

        if($user->getStatus()=="Active"){
            $user->setStatus("bloquer");
            $entityManager->flush();
            $data = [
                'status' => 200,
                'message' => 'utilisateur  bloquer'
            ];
            return new JsonResponse($data);
        }
        
        else{
            $user->setStatus("Active");
            $entityManager->flush();
            $data = [
                'status' => 200,
                'message' => 'utilisateur debloquer'
            ];
            return new JsonResponse($data);
        }
    }


}
