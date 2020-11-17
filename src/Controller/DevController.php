<?php

namespace App\Controller;

use App\Service\Emails\PHPMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    /**
     * @Route("/dev/send-email", name="dev")
     * @param PHPMailerService $mailerService
     */
    public function sendEmail(PHPMailerService $mailerService): bool
    {
        $response = $mailerService->send(
            [[$this->getParameter('admin_mail'), 'Martin Dhenu']],
            'Reset Password',
            'This is a email test '
        );

        die();
    }
}
