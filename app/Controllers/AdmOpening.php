<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmOpening
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'employé')){
                return __DIR__.'/../Views/admOpening.php';
        }
        else{
            $_SESSION['flash_message'] = 'Accès non autorisé';
            $_SESSION['flash_alert'] = 'danger';
            return __DIR__.'/../Views/homepage.php';
        }
    }

    public function put()
    {
        // echo $requestJSON;die;
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);
        // echo $request;die;
        $success = false;
        // if (isset($request['id'])) {
            $query = DbUtils::getPdo()->prepare("UPDATE opening SET 
                        opening_hour = :opening_hour, 
                        opening_minute = :opening_minute, 
                        closing_hour = :closing_hour, 
                        closing_minute = :closing_minute, 
                        closure = :closure
                        WHERE id = :id");

            foreach ($request as $id) {     
                if (isset($id) && $id !== null){                         
                    $query->bindValue('id', $id['id']);
                    $query->bindValue('opening_hour', DbUtils::protectDbData($id['opening_hour']));
                    $query->bindValue('opening_minute', DbUtils::protectDbData($id['opening_minute']));
                    $query->bindValue('closing_hour', DbUtils::protectDbData($id['closing_hour']));
                    $query->bindValue('closing_minute', DbUtils::protectDbData($id['closing_minute']));
                    $query->bindValue('closure', DbUtils::protectDbData($id['closure']));
                    if($query->execute()){
                        $success = true;
                    }else{
                        $success = false;
                    }
                }
            }

            if ($success){
                echo json_encode([
                    'success' => true,
                    'message' => 'Horaires modifiées',
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Erreur du serveur lors de l\'exécution de la requête',
                ]);
            }
    }
}