<?php

namespace Almhdy\Simy\Helpers;

use Almhdy\Simy\Core\Email\Email;

class EmailHelper
{
    public static function sendWelcomeEmail(string $recipient, string $name, string $language = 'en'): bool
    {
        $email = new Email('your-email@example.com', $language);
        $email->setRecipient($recipient);
        $email->setSubject('Welcome to Our Service');

        $email->loadTemplate('welcome', ['name' => $name]);

        // Optional: Set SMTP config if needed
        $email->setSmtpConfig([
            'host' => 'smtp.example.com',
            'username' => 'your-smtp-username',
            'password' => 'your-smtp-password',
            'port' => 587
        ]);

        return $email->send();
    }
}