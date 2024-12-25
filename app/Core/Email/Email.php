<?php

namespace Almhdy\Simy\Core\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Almhdy\Simy\Core\Translation\Translation;

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
    private string $language;

    /**
     * Constructor for Email class
     *
     * @param string $sender The email address of the sender
     * @param string $language The language for the email
     */
    public function __construct(string $sender, string $language = 'en') {
        $this->sender = $sender;
        $this->language = $language;
        Translation::setLanguage($language);
    }

    /**
     * Load an email template and replace placeholders with actual values
     *
     * @param string $templateName The name of the template file (without extension)
     * @param array $placeholders An associative array of placeholders and their values
     */
    public function loadTemplate(string $templateName, array $placeholders): void {
        $templatePath = __DIR__ . "/../../Templates/Emails/{$this->language}/{$templateName}.html";

        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException('Template file does not exist');
        }

        $templateContent = file_get_contents($templatePath);

        foreach ($placeholders as $placeholder => $value) {
            $templateContent = str_replace("{{{$placeholder}}}", $value, $templateContent);
        }

        $this->body = $templateContent;
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
}