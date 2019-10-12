<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Form\GuideType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GuideController extends AbstractController
{
    /**
     * @Route("/moderation/guide", name="guide")
     */
    public function index(Request $request)
    {

        $newPartGuide = new Guide;

        $form = $this->createForm(GuideType::class, $newPartGuide);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newPartGuide = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($newPartGuide);
            $em->flush();

            $this->addFlash('success', 'Paragraphe ajouté !');

            return $this->redirectToRoute('guide');
        }

        $guideList = $this->getDoctrine()->getRepository(Guide::class)->findAll();

        return $this->render('guide/index.html.twig', [
            'controller_name' => 'GuideController',
            'guideForm' => $form->createView(),
            'guideList' => $guideList
        ]);
    }


    /**
     * @Route("/moderation/guide/edit/{id}", name="guide_edit")
     */
    public function edit(Guide $guide, Request $request)
    {
        $form = $this->createForm(GuideType::class, $guide);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $editGuide = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($editGuide);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée');

            return $this->redirectToRoute('guide');
        }

        return $this->render('guide/edit.html.twig', [
            'controller_name' => 'GuideEditController',
            'guideForm' => $form->createView(),
            'partId'=> $guide->getId()

        ]);
    }


    
    /**
     * @Route("/moderation/guide/delete/{id}", name="guide_delete")
     */   
    public function delete(Guide $guide)    
    {
        
        $em = $this->getDoctrine()->getManager();

        $em->remove($guide);
        $em->flush();

        $this->addFlash('success', 'La section a bien été supprimée.');
        
        return $this->redirectToRoute('guide');
    }
}
