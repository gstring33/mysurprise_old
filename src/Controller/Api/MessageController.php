<?php

namespace App\Controller\Api;

use App\Entity\Message;
use App\Repository\UserRepository;
use App\Service\Emails\PHPMailerService;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const SUCCESS_STATUS = "success";
    const ERROR_STATUS = "error";
    const SUCCESS_POST_MESSAGE_ANONYMOUS  = "Ton message a été envoyé à %s";
    const SUCCESS_POST_MESSAGE = "Ton message a été envoyé à ton partenaire";
    const ERROR_POST_MESSAGE  = "Ton message n'a pas pu être envoyé";
    const MESSAGE_TYPE_HOST = "host";
    const MESSAGE_TYPE_GUEST = "guest";

    /**
     * @Route("/api/message", name="api_post_message", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param MessageService $messageService
     * @param PHPMailerService $mailerService
     * @return Response
     */
    public function index(
        Request $request,
        UserRepository $userRepository,
        MessageService $messageService,
        PHPMailerService $mailerService
    ): Response
    {
        $data = json_decode($request->getContent(), true);
        $type = $data["type"];
        $message = $data["message"];
        $currentUser = $this->getUser();
        $sentTo = null;

        //Send private message
        if($type === self::MESSAGE_TYPE_HOST ) {
            $sentTo = $currentUser->getSelectedUser();
            if($sentTo !== null) {
                $messageService->sendMessage($currentUser, $sentTo, $type, $message);
                $alertMessage = sprintf(self::SUCCESS_POST_MESSAGE_ANONYMOUS, $sentTo->getFirstname());
            }
        }elseif ($type === self::MESSAGE_TYPE_GUEST) {
            $sentTo = $userRepository->findSelectedBy($currentUser);
            $messageService->sendMessage($currentUser, $sentTo, $type, $message);
            $alertMessage = self::SUCCESS_POST_MESSAGE;
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

        // Send Email
        $sentFrom = $type === MessageController::MESSAGE_TYPE_HOST ? "ton partenaire (Anonyme)" : $sentTo->getFirstname();
        $mailerService->send(
            [[$sentTo->getEmail(), $sentTo->getFirstName() . " " . $sentTo->getLastname()]],
            'Nouveau message de  ' . $sentFrom,
            $this->renderView("message/message_email.html.twig", [
                'sentTo' => $sentTo,
                'sentFrom' => $sentFrom
            ])
        );

        $alert = $this->renderView("partials/alert.html.twig", ["type" => "success", "message" => $alertMessage]);
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
