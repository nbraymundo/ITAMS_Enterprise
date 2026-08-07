<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    public static function status(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect(string $url): never
    {
        header("Location: {$url}");
        exit;
    }

    public static function json(array $data, int $status = 200): never
    {
        self::status($status);

        header('Content-Type: application/json');

        echo json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}