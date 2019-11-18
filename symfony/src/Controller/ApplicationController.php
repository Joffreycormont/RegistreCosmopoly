<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Comment;
use App\Form\ApplicationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/moderation/application", name="application")
     */
    public function index(Request $request)
    {

        // Formulaire du pour une candidature

        $newPartApplication = new Application;
        
        $form = $this->createForm(ApplicationType::class, $newPartApplication);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newPartApplication = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($newPartApplication);
            $em->flush();

            $this->addFlash('success', 'Nouvelle candidature ajoutée');

            return $this->redirectToRoute('application');
        }

        // Formulaire pour un commentaire

        $applicationList = $this->getDoctrine()->getRepository(Application::class)->findAll();

        return $this->render('application/index.html.twig', [
            'controller_name' => 'ApplicationController',
            'applicationList' => $applicationList,
            'applicationForm' => $form->createView(),
        ]);
    }

    /**
     * 
     * @Route("/moderation/application/delete/{id}", name="application_delete")
     */
    public function delete (Application $application){

        $em = $this->getDoctrine()->getManager();

        $em->remove($application);
        $em->flush();

        $this->addFlash('success', 'La candidature a bien été suprimée');
        

        return $this->redirectToRoute('application');
    }



    /**
     * 
     * @Route("/moderation/application/{id}/comment/add", name="application_comment_add")
     */
    public function addComment (Application $application, Request $request, Security $security){

        // Formulaire pour un commentaire
        $content = $request->request->get('content');

        // Utilisateur qui poste le commentaire
        $user = $security->getUser();

        $newPartComment = new Comment;

            $newPartComment->setApplication($application);
            $newPartComment->setUser($user);
            $newPartComment->setContent($content);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newPartComment);
            $em->flush();

            $this->addFlash('success', 'Nouveaux commentaire ajouté');

        return $this->redirectToRoute('application');
    }

}
