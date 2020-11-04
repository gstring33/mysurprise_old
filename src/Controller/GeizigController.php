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

    /**
     * GeizigController constructor.
     * @param GiftsListRepository $giftsListRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        GiftsListRepository $giftsListRepository,
        UserRepository $userRepository
    ){
        $this->giftsListRepository = $giftsListRepository;
        $this->userRepository = $userRepository;
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
     * @Route("jemanden-auswählen", name="app_select_someone")
     * @return Response
     */
    public function selectSomeone()
    {
        return $this->render('geizig/manage_list.html.twig', [
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
