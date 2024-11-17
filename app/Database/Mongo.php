<?php
namespace App\Database;

use MongoDB\Client;
use MongoDB\Collection;
use Dotenv\Dotenv;

error_reporting(E_ALL & ~E_DEPRECATED);

class Mongo
{
    private static ?Client $client = null;
    private static ?Collection $collection = null;

    public static function loadEnv(): void
    {
        // Charge le fichier .env depuis le répertoire racine du projet
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    public static function getMongo(): Collection
    {
        if (self::$collection !== null) {
            return self::$collection;
        }

        if (self::$client === null) {
            // if (empty($_ENV['MONGO_HOST'])) {
            //     self::loadEnv();
            // }

            $host = $_ENV['MONGO_HOST'];
            $port = $_ENV['MONGO_PORT'];
            $username = $_ENV['MONGO_ROOT_USERNAME'];
            $password = $_ENV['MONGO_ROOT_PASSWORD'];
            $database = $_ENV['MONGO_DATABASE'];

            $uri = "mongodb://{$username}:{$password}@{$host}:{$port}/";
            
            try {
                self::$client = new Client($uri);
                $database = self::$client->selectDatabase($database);
                self::$collection = $database->selectCollection('click');
            } catch (\Exception $e) {
                throw new \Exception("Erreur de connexion MongoDB : " . $e->getMessage());
            }
        }

        return self::$collection;
    }

    public function nbClick(string $animal_name): void
    {
        $animal_name = strtolower($animal_name);
        $collection = self::getMongo();
        $result = $collection->findOne(['name' => $animal_name]);
        
        echo json_encode($result ? $result['click'] : "NaN");
    }

    public function addAnimal(string $animal_name): void
    {
        $animal_name = strtolower($animal_name);
        $collection = self::getMongo();
        $result = $collection->findOne(['name' => $animal_name]);

        if (!$result) {
            $collection->insertOne([
                'name' => $animal_name,
                'click' => 0,
            ]);
            // echo json_encode(['message' => "{$animal_name} a été ajouté à la base de données."]);
        } else {
            // echo json_encode(['error' => "{$animal_name} existe déjà dans la base de données."]);
        }
    }

    public function updateAnimal(string $animal_name, string $newName): void
    {
        $animal_name = strtolower($animal_name);
        $newName = strtolower($newName);
        $collection = self::getMongo();
        $result = $collection->findOne(['name' => $animal_name]);

        if ($result) {
            $collection->updateOne(
                ['name' => $animal_name], 
                ['$set' => ['name' => $newName]] 
            );
            // echo json_encode(['message' => "{$animal_name} a été ajouté à la base de données."]);
        } else {
            // echo json_encode(['error' => "{$animal_name} existe déjà dans la base de données."]);
        }
    }

    public function deleteAnimal(string $animal_name): void
    {
        $animal_name = strtolower($animal_name);
        $collection = self::getMongo();
        $result = $collection->findOne(['name' => $animal_name]);

        if ($result) {
            $collection->deleteOne(['name' => $animal_name]);
            // echo json_encode(['message' => "{$animal_name} est supprimé de la base de données."]);
        } else {
            // echo json_encode(['error' => "Aucun animal trouvé pour {$animal_name}"]);
        }
    }

    public function addClick(string $animal_name): void
    {
        $animal_name = strtolower($animal_name);
        $collection = self::getMongo();
        $result = $collection->findOne(['name' => $animal_name]);

        if ($result) {
            $newClickValue = $result['click'] + 1;
            $collection->updateOne(
                ['name' => $animal_name],
                ['$set' => ['click' => $newClickValue]]
            );
            $updated = $collection->findOne(['name' => $animal_name]);
            echo json_encode($updated['click']);
        } else {
            echo json_encode(['error' => "Aucun document trouvé pour {$animal_name}"]);
        }
    }


    private static function getEnv(string $key, $default = null)
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        $value = getenv($key);
        return $value !== false ? $value : $default;
    }
}