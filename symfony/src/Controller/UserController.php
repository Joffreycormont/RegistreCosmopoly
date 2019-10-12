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



        $userList = $this->getDoctrine()->getRepository(User::class)->findAll();



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
}
