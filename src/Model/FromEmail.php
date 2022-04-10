<?php

declare(strict_types=1);

namespace App\Model;

final class FromEmail
{
    public function __construct(private string $email, private string $name)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
