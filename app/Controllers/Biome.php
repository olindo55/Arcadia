<?php
namespace App\Controllers;
use App\Database\Mongo;

class Biome
{
    public function view()
    {
        return __DIR__.'/../Views/biome.php';
    }

    public function addClick()
    {
        $mongo = new Mongo();

        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);

        if (isset($request['name'])){
            $animal_name = strtolower($request['name']);
            $mongo->addClick($animal_name);

            echo json_encode([
                'success' => true,
                'message' => '+1',
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Pas de nom',
            ]);
        }
    }
}