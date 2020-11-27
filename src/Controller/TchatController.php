<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TchatController extends AbstractController
{
    /**
     * @Route("/nachrichten", name="app_messages")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        //Get messages host
        $currentUser = $this->getUser();
        $tchatHostMessages = $currentUser->getTchatroom()->getMessages();

        //Get messages guest
        $selectedByUser = $currentUser->getIsSelected() ? $userRepository->findSelectedBy($currentUser) : null;
        $tchatGuestMesages = $currentUser->getIsSelected() ? $selectedByUser->getTchatRoom()->getMessages() : null;
        $tchatGuestMessagesTotal = $currentUser->getIsSelected() ? count($tchatGuestMesages) : 0;

        $selectedUser = $currentUser->getSelectedUser();

        return $this->render('geizig/messages.html.twig', [
            'selectedUser' => $selectedUser,
            'tchatHostMessages' => $tchatHostMessages,
            'tchatHostMessagesTotal' => count($tchatHostMessages),
            'tchatGestMessages' => $tchatGuestMesages,
            'tchatGuestMessagesTotal' => $tchatGuestMessagesTotal
        ]);
    }
}
