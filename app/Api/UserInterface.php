<?php
declare(strict_types=1);

namespace App\Api;

interface UserInterface
{
    const USER_ID = 'id';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const EMAIL = 'email';
    const CREATED_AT = 'created_at';
    const PASSWORD_HASH = 'password_hash';

    public function getId(): int;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getEmail(): string;

    public function getCreatedAt(): string;

    public function getPasswordHash(): string;

    public function setId(int $id): void;

    public function setFirstName(string $firstName): void;

    public function setLastName(string $lastName): void;

    public function setEmail(string $email): void;

    public function setCreatedAt(string $createdAt): void;

    public function setPasswordHash(string $passwordHash): void;
}
