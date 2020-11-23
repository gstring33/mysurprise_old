<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAdminController extends AbstractController
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * UserAdminController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/admin", name="app_user_admin")
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('user_admin/index.html.twig', [
            'users' => $users,
        ]);
    }
}
