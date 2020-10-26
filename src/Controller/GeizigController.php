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
        $isAllowedToSelectedUser = false;
        $user = $this->getUser();
        $totalUsers = count($userRepository->findAll());
        $totalPublishedList = count($giftsListRepository->findPublishedList());


        return $this->render('geizig/index.html.twig', [
            'user' => $user,
            'page' => 'Homepage',
            'isAllowedToSelectUser' => $isAllowedToSelectedUser,
            'totalLists' => $totalUsers,
            'publishedLists' => $totalPublishedList
        ]);
    }
}
