<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encode)
    {   
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $hash=$encode->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            'form'=>$form->createView()
        ]);
    }
     /**
     * @Route("/login", name="security_login")
     */
    public function login()
    { 
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            
        ]);
    }
/**
 * @Route("/securite/logout", name="security_logout")
 */
 public function logout(){}
    
}
