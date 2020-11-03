<?php

namespace App\Controller\Api;

use App\Entity\Gift;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ListController
 * @Route("/api")
 * @package App\Controller\Api
 */
class GiftController extends AbstractController
{
    const SUCCESS_POST_MESSAGE = "Ihre Geschenksidee wurde erfolgreich gespeichert";
    const SUCCESS_DELETE_MESSAGE = "Ihre Geschenksidee wurde erfolgreich entfernt";
    const FAILED_MESSAGE = "Ihre Geschenkensidee kann nicht gespeichert werden";
    const SUCCESS_STATUS = "success";
    const FAILED_STATUS = "failed";

    /**
     * @Route("/gift", name="api_post_gift", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function postGift(Request $request, ValidatorInterface $validator): Response
    {
        $data= json_decode($request->getContent(), true);

        $user = $this->getUser();
        $listUser = $user->getGiftsList();
        $em = $this->getDoctrine()->getManager();

        $gift = new Gift();
        $gift->setTitle($data["title"])
            ->setDescription($data["description"])
            ->setLink($data["link"]);
        $listUser->addGift($gift);

        $errors = $validator->validate($gift);
        if(count($errors) > 0) {
            $message = str_replace("{{value}}", $data['link'], $errors->get(0)->getMessage());

            return new Response(
                json_encode([
                    "status" => self::FAILED_STATUS,
                    "message" => self::FAILED_MESSAGE . ". " . $message
                ]),
                Response::HTTP_BAD_REQUEST,
                ["Content-type" => "application/json"]
            );
        }
        $em->persist($gift);

        $em->flush();

        return new Response(
            json_encode([
                "status" => self::SUCCESS_STATUS,
                "message" => self::SUCCESS_POST_MESSAGE,
                "content" => [
                    'id' => $gift->getId(),
                    'title' => $gift->getTitle(),
                    'description' => $gift->getDescription(),
                    'link' => $gift->getLink()
                ]
            ]),
            Response::HTTP_OK,
            ["Content-type" => "application/json"]
        );
    }

    /**
     * @Route("/gift/{id}", name="api_delete_gift", methods={"DELETE"})
     * @param Request $request
     * @return Response
     */
    public function deleteGift(Request $request, Gift $gift): Response
    {
        //TODO: validate if the user is ollowed to delete the ressource
        $em = $this->getDoctrine()->getManager();
        $em->remove($gift);
        $em->flush();

        return new Response(
            json_encode([
                "status" => self::SUCCESS_STATUS,
                "message" => self::SUCCESS_DELETE_MESSAGE
            ]),
            Response::HTTP_OK,
            ["Content-type" => "application/json"]
        );
    }
}