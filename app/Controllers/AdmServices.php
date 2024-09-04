<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmServices
{   
    public function view()
    {
        return __DIR__.'/../Views/admServices.php';
    }

    public function post(array $data, $files): array
    {
        if (isset($data['name']) &&
            isset($data['description']) &&
            isset($_FILE['upload']) &&
            isset($data['alt'])) 
            {
                $uploadDir = 'asset/images/services/'; 
                $uploadFile = $uploadDir . basename($files['upload']['name']);

                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $check = getimagesize($files['upload']['tmp_name']);

                if($check) {
                    if (move_uploaded_file($files['upload']['tmp_name'], $uploadFile)) {

                        $query = DbUtils::getPdo()->prepare('INSERT INTO service
                            (name, description, image_url, image_alt)
                            VALUES (
                                :name,
                                :description,
                                :upload,
                                :alt
                            )
                        ');
                    $query->bindValue('name', DbUtils::protectDbData($data['name']));
                    $query->bindValue('description', DbUtils::protectDbData($data['description']));
                    $query->bindValue('upload', '../../'.$uploadFile);
                    $query->bindValue('alt', DbUtils::protectDbData($data['alt']));
                    
                    if($query->execute()){
                        return ['success' => true,
                                'message' => 'Une erreur est survenue lors de l\'enregistrement.',
                                'data' => $data,
                        ];
                    }       
                } else {
                    return [
                        'success' => false,
                        'message' => 'Le service a été créé',
                        'data' => $data
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Le fichier \'est pas une image.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Champs vide. Insertion impossible !'
            ];
        }
    }

    public function put()
    {
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);
        
        if (isset($request['id'], $request['name'], $request['description'], $request['image_url'], $request['image_alt'])) {
            $id = $request['id'];
            $name = $request['name'];
            $description = $request['description'];
            $url = $request['image_url'];
            $alt = $request['image_alt'];

            $query = DbUtils::getPdo()->prepare("UPDATE service SET name = :name , description = :description , image_url = :image_url , image_alt = :image_alt WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($request['id']));
            $query->bindValue('name', DbUtils::protectDbData($request['name']));
            $query->bindValue('description', DbUtils::protectDbData($request['description']));
            $query->bindValue('image_url', DbUtils::protectDbData($request['image_url']));
            $query->bindValue('image_alt', DbUtils::protectDbData($request['image_alt']));
            $query->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Service modifié avec succès.',
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Erreur du serveur lors de l\'exécution de la requête',
            ]);
        }
    }

    public function delete()
    {   
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);

        if (isset($request['id'])) {
            $query = DbUtils::getPdo()->prepare("DELETE FROM service WHERE id = :id");
            $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
            if ($query->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Service supprimé avec succès.',
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Erreur du serveur lors de l\'exécution de la requête',
                ]);
            }
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Paramètre manquant',
            ]);
        }
    }
}

