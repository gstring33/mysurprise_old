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
        $user = $this->getUser();
        $totalUsers = count($userRepository->findAll());
        $totalPublishedList = count($giftsListRepository->findPublishedList());

        return $this->render('geizig/index.html.twig', [
            'user' => $user,
            'page' => 'Homepage',
            'totalLists' => $totalUsers,
            'publishedLists' => $totalPublishedList
        ]);
    }

    /**
     * @Route("create-list", name="app_manage_list")
     * @return Response
     */
    public function createList()
    {
        $user = $this->getUser();

        return $this->render('geizig/manage_list.html.twig', [
            'user' => $user,
            'page' => 'Liste ertsellen',
        ]);
    }
}
