<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route("/api")
 * @package App\Controller\Api
 */
class UserController extends AbstractController
{
    const SUCCESS_STATUS = "success";
    const FAILED_STATUS = "failed";

    /** @var UserRepository */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/selection", name="api_get_selection", methods={"GET"})
     * @return Response
     */
    public function getUserSelection(): Response
    {
        $user = $this->getUser();
        if($user->getSelectedUser() !== NULL) {
            return new Response(
                json_encode([
                    "status" => self::FAILED_STATUS,
                    "message" => "A user has been already selected",
                    "content" => []
                ])
            );
        }

        $users = $this->userRepository->findOtherUsersNotSelected($user->getId());
        $random = rand(0, count($users)-1);
        $userSelected = $users[$random];
        $em = $this->getDoctrine()->getManager();
        $userSelected->setIsSelected(1);
        $user->setSelectedUser($userSelected);
        $user->setIsAllowedToSelectUser(0);
        $em->flush();

        return new Response(
            json_encode([
                "status" => self::SUCCESS_STATUS,
                "message" => "User selection is completed",
                "content" => [
                    "firstname" => $userSelected->getFirstname(),
                    "lastname" => $userSelected->getLastname(),
                    "listPath" => $this->generateUrl('app_user_list'),
                    "image" => $userSelected->getImage()
                ]
            ])
        );
    }
}