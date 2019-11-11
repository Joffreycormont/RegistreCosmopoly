<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/moderation/utilisateurs", name="user")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $newUser = new User();

        $form = $this->createForm(UserType::class, $newUser);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newUser = $form->getData();

            $clearPassword = $newUser->getPassword();
            $encodedPassword = $encoder->encodePassword($newUser, $clearPassword);

            $newUser->setPassword($encodedPassword);

            $newUser->setBorderline(0);
            $newUser->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();

            $this->addFlash('success', 'Le joueur a bien été ajouté !');

            return $this->redirectToRoute('user');
        }



        $userList = $this->getDoctrine()->getRepository(User::class)->getAllUsersByASC();



        return $this->render('user/index.html.twig', [
            'controller_name' => 'Utilisateurs',
            'userList' => $userList,
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/moderation/profil/utilisateur/{id}", name="profil_user")
     */
    public function profil(User $user)
    {

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($user);

        return $this->render('user/profil_user.html.twig', [
            'controller_name' => 'Profiluser',
            'currentUser' => $currentUser
        ]);
    }

    /**
     * @Route("/moderation/profil/utilisateur/edit/{id}", name="profil_user_edit")
     */
    public function editProfil(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {

        $form = $this->createForm(UserType::class);
    

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'Profiluser',
            'userForm' => $form->createView(),
            'userId' => $user->getid(),
            'username' => $user->getUsername()
        ]);
    }

        /**
     * @Route("/moderation/profil/utilisateur/edit/{id}/submit", name="profil_user_edit_submit")
     */
    public function editProfilSubmit(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {

            $form = $this->createForm(UserType::class, $user);
    
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $editUser = $form->getData();
    
                $clearPassword = $editUser->getPassword();
                $encodedPassword = $encoder->encodePassword($editUser, $clearPassword);
    
                $editUser->setPassword($encodedPassword);
    
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($editUser);
                $em->flush();
    
                $this->addFlash('success', 'Les modifications ont bien été effectuées');
    
                return $this->redirectToRoute('user');
            }

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'Profiluser',
            'userForm' => $form->createView(),
            'userId' => $user->getid()
        ]);
    }
}
