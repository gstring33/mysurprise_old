<?php

namespace App\Controller;

use App\Repository\GiftsListRepository;
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

    /**
     * GeizigController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/", name="app_home")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('geizig/index.html.twig',[
            'page' => 'Homepage',
            "hasAlreadySelectedUser" => $this->userService->hasAlreadySelectedUser()
        ]);
    }

    /**
     * @Route("jemanden-auswählen", name="app_select_someone")
     * @return Response
     */
    public function selectSomeone()
    {
       if($this->userService->hasAlreadySelectedUser()) {
           return $this->redirectToRoute('app_home', [], 301);
       }
        return $this->render('geizig/select_someone.html.twig', [
            'page' => 'Jemanden auswählen',
        ]);
    }

    /**
     * @Route("liste-handeln", name="app_manage_liste")
     * @return Response
     */
    public function manageList()
    {
        return $this->render('geizig/manage_list.html.twig', [
            'page' => 'Liste manager'
        ]);
    }
}
