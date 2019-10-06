<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {

        $userList = $this->getDoctrine()->getRepository(User::class)->findAll();

        $assignatorList = $this->getDoctrine()->getRepository(User::class)->getAssignator();
        $moderatorList = $this->getDoctrine()->getRepository(User::class)->getModerator();
        $adminList = $this->getDoctrine()->getRepository(User::class)->getAdmin();

        $userBorderline = $this->getDoctrine()->getRepository(User::class)->getBorder();
        


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            "moderatorList" => $moderatorList,
            "assignatorList" => $assignatorList,
            "adminList" => $adminList,
            "userList" => $userList,
            "borderList" => $userBorderline
        ]);
    }

    /**
     * @Route("/admin/delete", name="admin_delete")
     */
    public function adminDelete(Request $request)
    {
        $userId = $request->request->get('userId');

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $currentUser->setRoles(["ROLE_USER"]);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->flush();

        return $this->redirectToRoute("admin");
    }

        /**
     * @Route("/admin/delete/border", name="admin_delete_border")
     */
    public function adminDeleteBorder(Request $request)
    {
        $userId = $request->request->get('userId');

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $currentUser->setBorderline(0);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->flush();

        return $this->redirectToRoute("admin");
    }

        /**
     * @Route("/admin/addRole", name="admin_addRole")
     */
    public function adminaddRole(Request $request)
    {
        $userId = $request->request->get('userId');
        $role = $request->request->get('role');

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $currentUser->setRoles([$role]);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->flush();


        return $this->redirectToRoute("admin");
    }

    /**
     * @Route("/admin/addBorder", name="admin_addBorder")
     */
    public function adminaddBorder(Request $request)
    {
        $userId = $request->request->get('userId');

        $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $currentUser->setBorderline(1);

        $em = $this->getDoctrine()->getManager();

        $em->persist($currentUser);
        $em->flush();


        return $this->redirectToRoute("admin");
    }    
}
