<?php

namespace App\Core;

class Mailer
{
    protected array $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public function send(string $to, string $subject, string $message, bool $isHtml = false): bool
    {
        $fromName = str_replace(["\r", "\n", "\r\n"], '', $this->settings['smtp_from_name'] ?? ($this->settings['ngo_name'] ?? 'NGO'));
        $fromEmail = str_replace(["\r", "\n", "\r\n"], '', $this->settings['smtp_from_email'] ?? ($this->settings['ngo_email'] ?? 'noreply@ngo.com'));

        $headers = "From: {$fromName} <{$fromEmail}>\r\n";
        $headers .= "Reply-To: {$fromEmail}\r\n";
        $headers .= "X-Mailer: NGO Management System\r\n";

        if ($isHtml) {
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message = "<!DOCTYPE html><html><head><meta charset=\"UTF-8\"></head><body>{$message}</body></html>";
        } else {
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        }

        $subject = str_replace(["\r", "\n", "\r\n"], '', $subject);

        return mail($to, $subject, $message, $headers);
    }
}
