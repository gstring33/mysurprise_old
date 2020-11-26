<?php

namespace App\Controller;

use App\Repository\MessageRepository;
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
        $currentUser = $this->getUser();
        $selectedUser = $currentUser->getSelectedUser();
        $tchatHostMessages = $currentUser->getTchatroom()->getMessages();

        return $this->render('tchat/index.html.twig', [
            'selectedUser' => $selectedUser,
            'tchatHostMessages' => $tchatHostMessages,
            'tchatHostMessagesTotal' => count($tchatHostMessages)
        ]);
    }
}
