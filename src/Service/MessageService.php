<?php


namespace App\Service;

use App\Controller\Api\MessageController;
use App\Entity\Message;
use App\Service\Emails\PHPMailerService;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    /** @var PHPMailerService */
    private $mailerService;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * MessageService constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(PHPMailerService $mailerService, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $user
     * @param string $type
     * @param string $message
     */
    public function sendMessage($from, $to, string $type, string $message)
    {
        $tchat = $type === MessageController::MESSAGE_TYPE_HOST ? $from->getTchatRoom() : $to->getTchatRoom();
        $newMessage = new Message();
        $newMessage->setTchatRoom($tchat)
            ->setUser($from)
            ->setType($type)
            ->setIsRead(0)
            ->setDate(new \DateTime())
            ->setContent($message);
        $this->manager->persist($newMessage);
        $this->manager->flush();
    }
}