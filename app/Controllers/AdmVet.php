<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmVet
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur') || ($_SESSION['role'] === 'vétérinaire')){
                return __DIR__.'/../Views/admVet.php';
        }
        else{
            $_SESSION['flash_message'] = 'Accès non autorisé';
            $_SESSION['flash_alert'] = 'danger';
            return __DIR__.'/../Views/homepage.php';
        }
    }

    public function post(array $data)
    {   
        header('Content-Type: application/json');
        if (isset($data['animal_id']) && isset($data['new-report-animal']) && trim($data['new-report-animal']) !== '' && isset($data['health-score'])) 
            {        
                $animalQuery = DbUtils::getPdo()->prepare("SELECT name FROM animal WHERE id = :id");
                $animalQuery->bindValue(':id', DbUtils::protectDbData($data['animal_id']));
                $animalQuery->execute();
                $animalResult = $animalQuery->fetch(\PDO::FETCH_ASSOC);

                $query = DbUtils::getPdo()->prepare('
                    INSERT INTO vet_report (date_report, comment, score, user_id, animal_id) 
                    VALUES (:date_report, :comment, :score, :user_id, :animal_id)
                    ');
                $query->bindValue('date_report',  date('Y-m-d H:i:s'));
                $query->bindValue('comment', DbUtils::protectDbData($data['new-report-animal']));
                $query->bindValue('score', DbUtils::protectDbData($data['health-score']));
                $query->bindValue('user_id', $_SESSION['user_id']);
                $query->bindValue('animal_id', DbUtils::protectDbData($data['animal_id']));
                
                if($query->execute()){
                    $data['id'] = DbUtils::getPdo()->lastInsertId();
                    $data['date'] = date('Y-m-d H:i:s');
                    $data['animal_name'] = $animalResult['name'];
                    echo json_encode([
                        'success' => true,
                        'message' => 'Le rapport vétérinaire a été créé avec success.',
                        'data' => $data,
                    ]);
                    exit();
                }else{
                    echo json_encode([
                        'success' => false,
                        'message' => 'Une erreur est survenue lors de l\'enregistrement.',
                        'data' => $data
                    ]);
                    exit();
                }  
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Champs vide. Insertion impossible !'
                ]);
                exit();
            }
    }

    // public function put()
    // {
    //     $requestJSON = trim(file_get_contents("php://input"));
    //     $request = json_decode($requestJSON, true);
        
    //     if (isset($request['id'], $request['name'], $request['diet'])) {
    //         $query = DbUtils::getPdo()->prepare("UPDATE breed SET name = :name, diet = :diet WHERE id = :id");
            
    //         $query->bindValue(':id', DbUtils::protectDbData($request['id']));
    //         $query->bindValue(':name', DbUtils::protectDbData($request['name']));
    //         $query->bindValue(':diet', DbUtils::protectDbData($request['diet']));
    
    //         $query->execute();

    //         echo json_encode([
    //             'success' => true,
    //             'message' => 'Information sur la race modifié avec succès.',
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'success' => false, 
    //             'message' => 'Erreur du serveur lors de l\'exécution de la requête',
    //         ]);
    //     }
    // }

    // public function delete()
    // {   
    //     $requestJSON = trim(file_get_contents("php://input"));
    //     $request = json_decode($requestJSON, true);

    //     if (isset($request['id'])) {
    //         // delete
    //         $query = DbUtils::getPdo()->prepare("DELETE FROM breed WHERE id = :id");
    //         $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
    //         if ($query->execute()) {
    //             // delete images
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'Enregistrement de la race supprimée avec succès.',
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'success' => false, 
    //                 'message' => 'Erreur du serveur lors de l\'exécution de la requête',
    //             ]);
    //         }
            
    //     } else {
    //         echo json_encode([
    //             'success' => false, 
    //             'message' => 'Paramètre manquant',
    //         ]);
    //     }
    // }

    
    // public function getDiet(){
    //     $query = DbUtils::getPdo()->query('SELECT * FROM dietary ORDER BY name ASC');
    //     $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        
    //     echo json_encode([
    //         'success' => true, 
    //         'message' => 'Recuperations des datas OK',
    //         'data' => $data,
    //     ]);
    // }
    
    public function test(){
        // var_dump($image['image_url']);
        // var_dump($image['image_url_hd']);
    }

}
