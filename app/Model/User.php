<?php

declare(strict_types=1);

namespace App\Model;

use App\Api\UserInterface;
use Core\Database;
use \PDO;
use \Exception;

class User extends DataObject implements UserInterface
{
    const USER_DB_NAME = 'users';
    private ?PDO $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function create(array $data): User
    {
        if ($this->isUserExistByEmail($data['email'])) {
            throw new Exception('User with such email already exist');
        }
        $dataSave = [
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ];
        $stmt = $this->connection->prepare('INSERT INTO ' . self::USER_DB_NAME . ' (first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->execute($dataSave);
        if ($result) {
            $lastId = $this->connection->lastInsertId();
            $this->setData($dataSave);
            $this->setId((int)$lastId);
        }
        return $this;
    }

    private function isUserExistByEmail(string $email): bool
    {
        $stmt = $this->connection->prepare('SELECT id FROM ' . User::USER_DB_NAME . ' WHERE email = ?');
        $stmt->execute([$email]);

        return (bool)$stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getId(): int
    {
        return (int)$this->getData(self::USER_ID);
    }

    public function getFirstName(): string
    {
        return (string)$this->getData(self::FIRST_NAME);
    }

    public function getLastName(): string
    {
        return (string)$this->getData(self::LAST_NAME);

    }

    public function getEmail(): string
    {
        return (string)$this->getData(self::EMAIL);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getData(self::CREATED_AT);
    }

    public function getPasswordHash(): string
    {
        return (string)$this->getData(self::PASSWORD_HASH);
    }

    public function setId(int $id): void
    {
        $this->setData(self::USER_ID, $id);
    }

    public function setFirstName(string $firstName): void
    {
        $this->setData(self::FIRST_NAME, $firstName);
    }

    public function setLastName(string $lastName): void
    {
        $this->setData(self::LAST_NAME, $lastName);
    }

    public function setEmail(string $email): void
    {
        $this->setData(self::EMAIL, $email);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->setData(self::PASSWORD_HASH, $passwordHash);
    }
}
