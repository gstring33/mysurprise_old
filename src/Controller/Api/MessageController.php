<?php

namespace App\Controller\Api;

use App\Entity\Message;
use App\Repository\UserRepository;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const SUCCESS_STATUS = "success";
    const ERROR_STATUS = "error";
    const SUCCESS_POST_MESSAGE_ANONYMOUS  = "Deine Nachricht wurde erfolreich an %s anonymous gesendet";
    const SUCCESS_POST_MESSAGE = "Deine Nachricht wurde erfolreich an deinen Partner gesendet";
    const ERROR_POST_MESSAGE  = "Deine Nachricht konnte nicht gesendet werden";
    const MESSAGE_TYPE_HOST = "host";
    const MESSAGE_TYPE_GUEST = "guest";

    /**
     * @Route("/api/message", name="api_post_message", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(Request $request,UserRepository $userRepository, MessageService $messageService): Response
    {
        $data= json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();

        if($data["type"] === self::MESSAGE_TYPE_HOST ) {
            $messageService->sendMessage($currentUser, $data["type"], $data["message"]);
            $userSelected = $currentUser->getSelectedUser()->getFirstname();
            $message = sprintf(self::SUCCESS_POST_MESSAGE_ANONYMOUS, $userSelected);

        }elseif ($data["type"] === self::MESSAGE_TYPE_GUEST) {
            $userSelectedBy = $userRepository->findSelectedBy($currentUser);
            $messageService->sendMessage($userSelectedBy, $data["type"], $data["message"]);
            $message = self::SUCCESS_POST_MESSAGE;
        }else {
            $alert = $this->renderView("partials/alert.html.twig", ["type" => "danger", "message" => self::ERROR_POST_MESSAGE]);
            return new Response(
                json_encode([
                    "status" => self::ERROR_STATUS,
                    "alert" => $alert
                ]),
                Response::HTTP_OK,
                ["Content-type" => "application/json"]
            );
        }

        $alert = $this->renderView("partials/alert.html.twig", ["type" => "success", "message" => $message]);
        return new Response(
            json_encode([
                "status" => self::SUCCESS_STATUS,
                "alert" => $alert
            ]),
            Response::HTTP_OK,
            ["Content-type" => "application/json"]
        );
    }
}
