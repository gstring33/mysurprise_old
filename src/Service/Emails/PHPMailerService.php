<?php

namespace App\Service\Emails;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PHPMailerService
{
    /** @var PHPMailer */
    private $mailer;

    /** @var string */
    private $from;
    /** @var string */
    private $host;
    /** @var string */
    private $port;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /**
     * @var int
     */
    private $debug_mode;

    /**
     * MailerService constructor.
     * @param string $from
     * @param string $host
     * @param string $port
     * @param string $username
     * @param string $password
     * @param int $debug_mode
     */
    public function __construct(string $from, string $host, string $port, string $username, string $password, int $debug_mode = 0)
    {
        $this->mailer= new PHPMailer();
        $this->from = $from;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->debug_mode = $debug_mode;
    }

    /**
     * @param array $addresses
     * @param string $subject
     * @param string $body
     * @return void
     */
    public function send(array $addresses, string $subject, string $body)
    {
        $this->initServer($this->host, $this->username, $this->password, $this->port)
            ->initRecipient($this->from, 'Das Perfekte Geschenk', $addresses)
            ->initContent($subject, $body);

        try {
            var_dump($this->mailer->send());
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $port
     * @return PHPMailerService
     */
    private function initServer(string $host, string $username, string $password, string $port)
    {
        try {
            if ($this->debug_mode == 1) {
                $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            }
            $this->mailer->isSMTP();
            $this->mailer->Host       = $host;
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $username;
            $this->mailer->Password   = $password;
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = $port;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }

        return $this;
    }

    /**
     * @param string $from
     * @param string $name
     * @param array $adresses
     * @param string|null $replyTo
     * @param string|null $cc
     * @param string|null $bcc
     * @return PHPMailerService
     * @return PHPMailer
     */
    private function initRecipient(string $from, string $name, array $adresses, ?string $replyTo = null, ?string $cc = null, ?string $bcc =null)
    {
        try {
            $this->mailer->setFrom($from, $name);
            foreach ($adresses as $adress) {
                $this->mailer->addAddress($adress[0], $adress[1]);
            }
            if ($replyTo !== null) {
                $this->mailer->addReplyTo('info@example.com', 'Information');
            }
            if ($cc !== null) {
                $this->mailer->addCC('cc@example.com');
            }
            if ($bcc !== null) {
                $this->mailer->addBCC('bcc@example.com');
            }
        }catch (Exception $e ) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }

        return $this;
    }

    /**
     * @param array $attachments
     * @return PHPMailerService
     */
    private function initAttachment(array $attachments) {
        try {
            foreach ($attachments as $attachment) {
                $this->mailer->addAttachment($attachment['path'], $attachment['name']);         // Add attachments
            }
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }

        return $this->mailer;
    }

    /**
     * @param string $subject
     * @param string $html
     * @return PHPMailer
     */
    private function initContent(string $subject, string $html)
    {
        try {
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $html;
            //$this->mailer->AltBody = 'This is the body in plain text for non-HTML mail clients';
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }

        return $this;
        return $this->mailer;
    }
}