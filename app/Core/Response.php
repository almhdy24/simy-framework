<?php

namespace Almhdy\Simy\Core;

class Response
{
    public function __construct()
    {
        header_remove(); // Remove previously set headers
    }

    // Method to respond with a JSON payload
    public static function json(array $data, int $status = 200): void
    {
        self::setHeaders('application/json', $status);
        echo json_encode($data);
        exit();
    }

    // Method to respond with a file download
    public static function download(string $filePath): void
    {
        if (file_exists($filePath)) {
            self::setHeaders('application/octet-stream', 200);
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            readfile($filePath);
            exit();
        } else {
            self::notFound();
        }
    }

    // Method to respond with an image
    public static function image(string $filePath): void
    {
        if (file_exists($filePath)) {
            $imageData = file_get_contents($filePath);
            $imageType = exif_imagetype($filePath);
            $contentType = image_type_to_mime_type($imageType);
            self::setHeaders($contentType, 200);
            echo $imageData;
            exit();
        } else {
            self::notFound();
        }
    }

    // Method to respond with plain text
    public static function text(string $content, int $status = 200): void
    {
        self::setHeaders('text/plain', $status);
        echo $content;
        exit();
    }

    // Method to redirect to a different URL
    public static function redirect(string $url, int $status = 302): void
    {
        header("Location: " . $url, true, $status);
        exit();
    }

    // Method to respond with HTML content
    public static function html(string $content, int $status = 200): void
    {
        self::setHeaders('text/html', $status);
        echo $content;
        exit();
    }

    // Method to respond with a 500 Internal Server Error
    public static function serverError(string $message = '500 Internal Server Error'): void
    {
        self::setHeaders('text/plain', 500);
        echo $message;
        exit();
    }

    // Method to respond with a 404 Not Found error
    public static function notFound(string $message = '404 Not Found'): void
    {
        self::setHeaders('text/plain', 404);
        echo $message;
        exit();
    }

    // Private method to set headers
    private static function setHeaders(string $contentType, int $status): void
    {
        header("Content-Type: " . $contentType);
        http_response_code($status);
    }
}