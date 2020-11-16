<?php

namespace App\Service\Emails;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ResetPasswordMailerService
{
    /** @var PHPMailer */
    private $mailer;

    const EMAIL_SUBJECT = "Reset your password";

    /**
     * MailerService constructor.
     * @param string $adminMail
     * @param string $from
     * @param string $host
     * @param string $port
     * @param string $username
     * @param string $password
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function __construct(string $from, string $host, string $port, string $username, string $password)
    {
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->Port = $port;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
        $this->from = $from;
        $this->mailer->setFrom($this->from);
        $this->mailer->Subject = self::EMAIL_SUBJECT;
    }

    /**
     * @param string $address
     * @param string $receiverName
     * @param string $body
     * @return string[]
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(string $address, string $receiverName, string $body) {
        $this->mailer->addAddress($address, $receiverName);
        $this->mailer->Body = $body;

        return $this->mailer->send();
    }
}