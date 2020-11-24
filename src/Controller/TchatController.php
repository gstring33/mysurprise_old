<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TchatController extends AbstractController
{
    /**
     * @Route("/nachrichten", name="app_messages")
     */
    public function index(): Response
    {
        return $this->render('tchat/index.html.twig', [
            'controller_name' => 'TchatController',
        ]);
    }
}
