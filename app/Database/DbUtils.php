<?php

namespace App\Database;

use PDO;

class DbUtils
{
    static ?PDO $pdo = null;

    public static function getPdo(): PDO    
    {
        // Singleton design pattern
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        self::$pdo = new \PDO(self::getDSN(), self::getUser(), self::getPassword());
        return self::$pdo;
    }

    private static function getEnv($key, $default = null)
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }
        
        return $default;
    }

    public static function getDSN()
    {
        $host = 'mysql';
        $dbname = self::getEnv('MYSQL_DATABASE');
        $port = '3306';
        return "mysql:host={$host};dbname={$dbname};port={$port}";
    }
    public static function getUser()
    {
        return self::getEnv('MYSQL_USER');
    }

    public static function getPassword()
    {
        return self::getEnv('MYSQL_PASSWORD');
    }

    public static function protectDbData($value)
    {
        $value = htmlspecialchars($value);
        $value = strip_tags($value);

        return $value;
    }
}
