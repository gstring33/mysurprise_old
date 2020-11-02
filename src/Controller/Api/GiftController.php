<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ListController
 * @Route("/api")
 * @package App\Controller\Api
 */
class GiftController extends AbstractController
{
    /**
     * @Route("/gift-list", name="api_gift", methods={"POST"})
     * @param Request $request
     */
    public function postGift(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        var_dump($data); die();
    }
}