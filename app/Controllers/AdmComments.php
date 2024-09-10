<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmComments
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'employé')){
                return __DIR__.'/../Views/admComments.php';
        }
        else{
            $_SESSION['flash_message'] = 'Accès non autorisé';
            $_SESSION['flash_alert'] = 'danger';
            return __DIR__.'/../Views/homepage.php';
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
            $query = DbUtils::getPdo()->prepare("DELETE FROM comment WHERE id = :id");
            $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
            if ($query->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Avis supprimé avec succès.',
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

