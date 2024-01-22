<?php

namespace App\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailHogMailer
{
    private string $to;
    private string $subject;
    private string $message;
    private string $from;
    private string $smtpServer;
    private int $smtpPort;

    public function __construct(string $to, string $subject, string $message, string $from, string $smtpServer = "127.0.0.1", int $smtpPort = 1025)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
        $this->smtpServer = $smtpServer;
        $this->smtpPort = $smtpPort;
    }

    public function send(): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Налаштування сервера і параметрів
            $mail->isSMTP();
            $mail->Host = $this->smtpServer;
            $mail->Port = $this->smtpPort;

            // Налаштування відправника і отримувача
            $mail->setFrom($this->from);
            $mail->addAddress($this->to);

            // Встановлення теми та тіла листа
            $mail->Subject = $this->subject;
            $mail->Body = $this->message;

            // Відправлення листа
            $mail->send();
            return true;
        } catch (Exception $e) {
            dump($e);
            return false;
        }
    }
}