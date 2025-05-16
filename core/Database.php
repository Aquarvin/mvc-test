<?php

declare(strict_types=1);

namespace Core;

use \PDO;
use \PDOException;

class Database
{
    private $pdo;

    public function getConnection()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
        return $this->pdo;
    }
}
