<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const SUCCESS_STATUS = "success";
    const SUCCESS_POST_MESSAGE  = "Deine Nachricht wurde erfolreich an %s gesendet";

    /**
     * @Route("/api/message", name="api_post_message", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $data= json_decode($request->getContent(), true);

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
