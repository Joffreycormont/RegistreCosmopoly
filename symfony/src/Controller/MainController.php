<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/mon-profil", name="profil")
     */
    public function profil(Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getId();

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);


        return $this->render('main/profil.html.twig', [
            'controller_name' => 'Profil',
            'currentUser' => $currentUser
        ]);
    }
}
