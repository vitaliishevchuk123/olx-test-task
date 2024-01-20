<?php

namespace App\Forms\User;

class SubscribeAnnouncementForm
{
    private ?string $name;
    private ?string $email;
    private ?string $url;
    private array $validationErrors = [];

    public function setFields(?string $email, ?string $url, ?string $name): self
    {
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
        return $this;
    }

    public function validate(): self
    {
        $this->validationErrors = [];

        if (empty($this->name)) {
            $this->validationErrors[] = 'Назва користувача - обовʼязкове поле';
        }

        if (!empty($this->name) && strlen($this->name) > 50) {
            $this->validationErrors[] = 'Максимальна довжина імені 50 символів';
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors[] = 'Неправильний формат електронної пошти';
        }

        if (empty($this->email) || !filter_var($this->url, FILTER_VALIDATE_URL)) {
            $this->validationErrors[] = 'Неправильний формат силки на ОЛХ оголошення';
        }

        return $this;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->validationErrors);
    }
}