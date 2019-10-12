<?php

namespace App\Controller;

use App\Entity\Sanction;
use App\Entity\User;
use App\Form\SanctionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SanctionController extends AbstractController
{
    /**
     * @Route("/moderation/sanction", name="sanction_list")
     */
    public function index()
    {

        $form = $this->createForm(SanctionType::class);

        $sanctionList = $this->getDoctrine()->getRepository(Sanction::class)->findByDesc();


        return $this->render('sanction/index.html.twig', [
            'controller_name' => 'SanctionController',
            'sanctionList' => $sanctionList,
            'sanctionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/moderation/sanction/add", name="sanction_add", methods={"POST"})
     */
    public function add(Request $request, Security $security)
    {

        $moderator = $security->getUser();
        $moderator = $moderator->getUsername();

        $newSanction = new Sanction();

        $form = $this->createForm(SanctionType::class, $newSanction);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $newSanction = $form->getData();

            $newSanction->setModerator($moderator);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newSanction);
            $em->flush();

            $this->addFlash('success', 'La sanction a bien été ajoutée !');

            return $this->redirectToRoute('sanction_list');
            exit;
        }
        dump($form->isSubmitted());
        dump($form->isValid());
        exit;

    }

    /**
     * @Route("/moderation/sanction/search/{$id}", name="sanction_search", methods={"POST"})
     */
    public function search(Request $request)
    {
        $user = $request->request->get('username');

        $userId = $this->getDoctrine()->getRepository(User::class)->findByUsername($user);
        
        if($userId){
            $userId = $userId[0]['id'];

            $sanctionList = $this->getDoctrine()->getRepository(Sanction::class)->findByUser($userId);
            
    
            return $this->render('sanction/search.html.twig', [
                'controller_name' => 'Search',
                'sanctionList' => $sanctionList,
                'user' => $user
            ]);
        }
        
        $this->addFlash('warning', 'Utilisateur inconnu, tu as peut-être mal écris le pseudo !');

        return $this->redirectToRoute('sanction_list');
    }
}
