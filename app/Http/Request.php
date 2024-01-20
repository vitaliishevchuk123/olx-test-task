<?php

namespace App\Http;

class Request
{
    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPath(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, mixed $default = null)
    {
        return $this->postData[$key] ?? $default;
    }

    public function get(string $key, mixed $default = null)
    {
        return $this->getParams[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->getParams, $this->postData);
    }
}
