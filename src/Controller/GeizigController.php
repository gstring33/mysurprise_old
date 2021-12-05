<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ListManager;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeizigController extends AbstractController
{
    /** @var UserService */
    private $userService;
    /** @var UserRepository */
    private $userRepository;

    /**
     * GeizigController constructor.
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="app_home")
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if($user->getIsFirstConnection()) {
            $em = $this->getDoctrine()->getManager();
            $user->setIsFirstConnection(0);
            $em->persist($user);
            $em->flush();
        }

        $list = $this->getUser()->getGiftsList()->getGifts();

        return $this->render('geizig/index.html.twig',[
            'page' => 'Homepage',
            "hasAlreadySelectedUser" => $this->userService->hasAlreadySelectedUser(),
            "totalGifts" => count($list),
            "list" => $list
        ]);
    }

    /**
     * @Route("partner-ziehen", name="app_select_someone")
     * @return Response
     */
    public function selectSomeone()
    {
        if($this->userService->hasAlreadySelectedUser()) {
            return $this->redirectToRoute('app_home', [], 301);
        }

        return $this->render('geizig/select_someone.html.twig', [
            'page' => 'Jemanden ziehen',
        ]);
    }

    /**
     * @Route("liste-bearbeiten", name="app_manage_liste")
     * @return Response
     */
    public function manageList()
    {
        return $this->render('geizig/manage_list.html.twig', [
            'page' => 'Gérer ma liste'
        ]);
    }


    /**
     * @Route("nutzer-liste", name="app_user_list")
     */
    public function listUser()
    {
        $user = $this->getUser();
        $selectedUser = $user->getSelectedUser();

        if(empty($selectedUser)) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('geizig/selected_user_list.html.twig', [
            'page' => 'Liste de la personne tirée au sort',
            'list' => $selectedUser->getGiftsList()->getGifts(),
            'selectedUser' => $selectedUser
        ]);
    }
}
