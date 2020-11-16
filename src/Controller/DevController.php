<?php

namespace App\Controller;

use App\Service\Emails\ResetPasswordMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DevController extends AbstractController
{
    /**
     * @Route("/dev/send-email", name="dev")
     * @param ResetPasswordMailerService $mailerService
     */
    public function sendEmail(ResetPasswordMailerService $mailerService): bool
    {
        $response = $mailerService->send(
            $this->getParameter('admin_mail'),
            'John Doe',
            'This is a email test '
        );

        var_dump($response); die();
    }
}
