<?php

namespace App\Controller;

use App\Repository\GiftsListRepository;
use App\Repository\UserRepository;
use App\Service\ListManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeizigController extends AbstractController
{
    /** @var GiftsListRepository */
    private $giftsListRepository;
    /** @var UserRepository */
    private $userRepository;
    /** @var ListManager */
    private $listManager;

    /**
     * GeizigController constructor.
     * @param GiftsListRepository $giftsListRepository
     * @param UserRepository $userRepository
     * @param ListManager $listManager
     */
    public function __construct(
        GiftsListRepository $giftsListRepository,
        UserRepository $userRepository,
        ListManager $listManager
    ){
        $this->giftsListRepository = $giftsListRepository;
        $this->userRepository = $userRepository;
        $this->listManager = $listManager;
    }

    /**
     * @Route("/", name="app_home")
     * @return Response
     */
    public function index(): Response
    {
        $totalUsers = count($this->userRepository->findAll());
        $totalPublishedList = count($this->giftsListRepository->findPublishedList());

        return $this->render('geizig/index.html.twig', [
            'page' => 'Homepage',
            'totalLists' => $totalUsers,
            'publishedLists' => $totalPublishedList
        ]);
    }

    /**
     * @Route("liste-handeln", name="app_manage_list")
     * @return Response
     */
    public function manageList()
    {
        return $this->render('geizig/manage_list.html.twig', [
            'page' => 'Liste handeln',
        ]);
    }

    /**
     * @Route("jemanden-auswählen", name="app_select_someone")
     * @return Response
     */
    public function selectSomeone()
    {
        return $this->render('geizig/select_someone.html.twig', [
            'page' => 'Jemanden auswählen',
        ]);
    }

    /**
     * @Route("liste-erstellen", name="app_create_liste")
     * @return Response
     */
    public function createList()
    {
        $username = $this->getUser()->getUsername();
        $isAllowedToCreateList  = $this->listManager->isAllowedToCreateList($username);

        if(!$isAllowedToCreateList) {
            return $this->redirect($this->generateUrl("app_home"));
        }

        return $this->render('geizig/create_list.html.twig', [
            'page' => 'Liste erstellen'
        ]);
    }
}
