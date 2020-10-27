<?php

namespace App\Controller;

use App\Repository\GiftsListRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeizigController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param GiftsListRepository $giftsListRepository
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(
        GiftsListRepository $giftsListRepository,
        UserRepository $userRepository
    ): Response
    {
        $totalUsers = count($userRepository->findAll());
        $totalPublishedList = count($giftsListRepository->findPublishedList());

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
        return $this->render('geizig/create_list.html.twig', [
            'page' => 'Liste erstellen',
        ]);
    }
}
