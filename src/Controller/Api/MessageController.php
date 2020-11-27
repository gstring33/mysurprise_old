<?php

namespace App\Controller\Api;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const SUCCESS_STATUS = "success";
    const ERROR_STATUS = "error";
    const SUCCESS_POST_MESSAGE  = "Deine Nachricht wurde erfolreich an %s gesendet";
    const ERROR_POST_MESSAGE  = "Deine Nachricht konnte nicht gesendet werden";
    const MESSAGE_TYPE_HOST = "host";
    const MESSAGE_TYPE_GUEST = "guest";

    /**
     * @Route("/api/message", name="api_post_message", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data= json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();

        if($data["type"] === self::MESSAGE_TYPE_HOST ) {
            $tchat = $currentUser->getTchatRoom();
            $newMessage = new Message();
            $newMessage->setTchatRoom($tchat)
                ->setUser($currentUser)
                ->setType($data["type"])
                ->setIsRead(0)
                ->setDate(new \DateTime())
                ->setContent($data["message"]);
            $em->persist($newMessage);
            $em->flush();

        }elseif ($data["type"] === self::MESSAGE_TYPE_GUEST) {

        }else {
            return new Response(
                json_encode([
                    "status" => self::ERROR_STATUS,
                    "message" => self::ERROR_POST_MESSAGE
                ]),
                Response::HTTP_OK,
                ["Content-type" => "application/json"]
            );
        }

        return new Response(
            json_encode([
                "status" => self::SUCCESS_STATUS,
                "message" => self::SUCCESS_POST_MESSAGE
            ]),
            Response::HTTP_OK,
            ["Content-type" => "application/json"]
        );
    }
}
