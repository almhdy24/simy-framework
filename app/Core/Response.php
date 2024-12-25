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
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data);
        exit();
    }

    // Method to respond with a file download
    public static function download(string $filePath): void
    {
        if (file_exists($filePath)) {
            header("Content-Type: application/octet-stream");
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
            header("Content-Type: " . $contentType);
            echo $imageData;
            exit();
        } else {
            self::notFound();
        }
    }

    // Method to respond with plain text
    public static function text(string $content, int $status = 200): void
    {
        header("Content-Type: text/plain");
        http_response_code($status);
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
        header("Content-Type: text/html");
        http_response_code($status);
        echo $content;
        exit();
    }

    // Method to respond with a 500 Internal Server Error
    public static function serverError(): void
    {
        http_response_code(500);
        echo "500 Internal Server Error";
        exit();
    }

    // Method to respond with a 404 Not Found error
    public static function notFound(): void
    {
        http_response_code(404);
        echo "404 Not Found";
        exit();
    }
}