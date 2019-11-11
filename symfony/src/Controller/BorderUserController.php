<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BorderUserController extends AbstractController
{
    /**
     * @Route("/moderation/border/user", name="border_user")
     */
    public function index()
    {

        $userBorderline = $this->getDoctrine()->getRepository(User::class)->getBorderAdmin();

        return $this->render('border_user/index.html.twig', [
            'controller_name' => 'BorderUserController',
            'borderList' => $userBorderline
        ]);
    }
}
