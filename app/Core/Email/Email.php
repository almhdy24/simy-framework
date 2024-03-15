<?php

namespace Almhdy\Simy\Core\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Email
 * Handles sending emails using PHPMailer
 */
class Email {
    private string $sender;
    private string $recipient;
    private string $subject;
    private string $body;
    private array $cc = [];
    private array $bcc = [];
    private array $attachments = [];
    private array $smtpConfig = [];

    /**
     * Constructor for Email class
     *
     * @param string $sender The email address of the sender
     */
    public function __construct(string $sender) {
        $this->sender = $sender;
    }

    /**
     * Set the recipient email address
     *
     * @param string $recipient The email address of the recipient
     */
    public function setRecipient(string $recipient): void {
        if ($this->validateEmail($recipient)) {
            $this->recipient = $recipient;
        } else {
            throw new \InvalidArgumentException('Invalid email address');
        }
    }

    /**
     * Set the email subject
     *
     * @param string $subject The subject of the email
     */
    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    /**
     * Set the email body
     *
     * @param string $body The body of the email
     */
    public function setBody(string $body): void {
        $this->body = $body;
    }

    /**
     * Add CC recipient email address
     *
     * @param string $email The email address of the CC recipient
     */
    public function addCc(string $email): void {
        if ($this->validateEmail($email)) {
            $this->cc[] = $email;
        }
    }

    /**
     * Add BCC recipient email address
     *
     * @param string $email The email address of the BCC recipient
     */
    public function addBcc(string $email): void {
        if ($this->validateEmail($email)) {
            $this->bcc[] = $email;
        }
    }

    /**
     * Add attachment to the email
     *
     * @param string $filePath The path to the attachment file
     * @param string $fileName The name of the attachment file
     */
    public function addAttachment(string $filePath, string $fileName = ''): void {
        $this->attachments[] = ['path' => $filePath, 'name' => $fileName];
    }

    /**
     * Set SMTP configuration for sending emails
     *
     * @param array $config An array containing SMTP configuration parameters
     */
    public function setSmtpConfig(array $config): void {
        $this->smtpConfig = $config;
    }

    /**
     * Send the email
     *
     * @return bool Returns true if the email is sent successfully, false otherwise
     */
    public function send(): bool {
        $mail = new PHPMailer(true);

        try {
            $mail->setFrom($this->sender);
            $mail->addAddress($this->recipient);

            foreach ($this->cc as $ccEmail) {
                $mail->addCC($ccEmail);
            }

            foreach ($this->bcc as $bccEmail) {
                $mail->addBCC($bccEmail);
            }

            $mail->Subject = $this->subject;
            $mail->Body = $this->body;

            $mail->isHTML(true);

            foreach ($this->attachments as $attachment) {
                $mail->addAttachment($attachment['path'], $attachment['name']);
            }

            if (!empty($this->smtpConfig)) {
                $mail->isSMTP();
                $mail->Host = $this->smtpConfig['host'];
                $mail->SMTPAuth = true;
                $mail->Username = $this->smtpConfig['username'];
                $mail->Password = $this->smtpConfig['password'];
                $mail->Port = $this->smtpConfig['port'];
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Validate an email address
     *
     * @param string $email The email address to validate
     * @return bool Returns true if the email address is valid, false otherwise
     */
    private function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}