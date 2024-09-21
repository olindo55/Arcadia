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
        
        if (isset($request['id'], $request['published'])) {
            $id = $request['id'];
            // $published = isset($request['published']) ? 1 : 0;
            $published = intval($request['published']);
            
            $query = DbUtils::getPdo()->prepare("UPDATE comment SET published = :published, user_id = :user_id WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($request['id']));
            $query->bindValue('published', DbUtils::protectDbData($published));
            $query->bindValue('user_id', DbUtils::protectDbData($_SESSION['user_id']));
            $query->execute();

            echo json_encode([
                'success' => true,
                'message' => $published ? 'Avis publié' : 'Avis est désormais non publié',
                'data' => $_SESSION['name'] . ' ' . $_SESSION['forename'],
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

