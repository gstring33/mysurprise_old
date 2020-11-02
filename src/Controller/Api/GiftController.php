<?php

namespace App\Controller\Api;

use App\Entity\Gift;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ListController
 * @Route("/api")
 * @package App\Controller\Api
 */
class GiftController extends AbstractController
{
    const SUCCES = "Ihre Liste wurde erfolgreich gespeichert";

    /**
     * @Route("/gift-list", name="api_gift", methods={"POST"})
     * @param Request $request
     */
    public function postGift(Request $request): Response
    {
        $datas= json_decode($request->getContent(), true);

        if(count($datas) > 0 ) {
            $user = $this->getUser();
            $listUser = $user->getGiftsList();
            $em = $this->getDoctrine()->getManager();

            foreach ($datas as $data) {
                $gift = new Gift();
                $gift->setTitle($data["title"])
                    ->setDescription($data["description"])
                    ->setLink($data["link"]);

                $listUser->addGift($gift);
                $em->persist($gift);
            }

            $em->flush();

            return new Response(
                json_encode(["message" => self::SUCCES]),
                Response::HTTP_OK,
                ["Content-type" => "application/json"]
            );

        }
    }
}