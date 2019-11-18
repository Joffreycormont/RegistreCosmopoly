<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class VoteController extends AbstractController
{
    /**
     * @Route("/vote/{id}/add", name="vote")
     */
    public function index(Application $application, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getId();
    
        $voteList = $this->getDoctrine()->getRepository(Vote::class)->checkVote($userId, $application->getId());

        if(!$voteList){

            $newVote = new Vote;

            $newVote->setUserId($userId);
            $newVote->setApplicationId($application->getId());
    
            $em = $this->getDoctrine()->getManager();
            $em->persist($newVote);
    
    
            $updateCounter = $this->getDoctrine()->getRepository(Application::class)->find($application->getId());
            $currentCount = $updateCounter->getCounter();
            $updateCounter->setCounter($currentCount + 1);
    
            $emCounter = $this->getDoctrine()->getManager();
            $emCounter->persist($updateCounter);
    
    
            $emCounter->flush();
            $em->flush();
    
            $this->addFlash('success', 'Vote pris en compte');

            return $this->redirectToRoute('application');
        }else{

            $this->addFlash('warning', 'Ton vote pour cette candidature est déjà pris en compte');
            return $this->redirectToRoute('application');
        }

        



        /*return $this->render('vote/index.html.twig', [
            'controller_name' => 'VoteController',
        ]);*/
    }
}
