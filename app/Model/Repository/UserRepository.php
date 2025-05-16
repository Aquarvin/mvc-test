<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\User;
use Core\Database;

class UserRepository
{
    private ?\PDO $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    /**
     * @param string $email
     * @return \App\Model\User
     * @throws \Exception
     */
    public function getByEmail(string $email): User
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . User::USER_DB_NAME . ' WHERE email = ?');
        $result = $stmt->execute([$email]);
        if (!$result) {
            throw new \Exception('No such User found');
        }
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception('No such User found');
        }
        $user = new User();
        $user->setData($data);
        return $user;
    }

    /**
     * @param int $id
     * @return \App\Model\User
     * @throws \Exception
     */
    public function get(int $id): User
    {
        $stmt = $this->connection->prepare('SELECT * FROM ' . User::USER_DB_NAME . ' WHERE id = ?');
        $result = $stmt->execute([$id]);
        if (!$result) {
            throw new \Exception('No such User found');
        }
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            throw new \Exception('No such User found');
        }
        $user = new User();
        $user->setData($data);
        return $user;
    }
}
