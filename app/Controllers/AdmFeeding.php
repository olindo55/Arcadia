<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmFeeding
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'employé')){
                return __DIR__.'/../Views/admFeeding.php';
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
        if (isset($data['animal']) && isset($data['qte']) && isset($data['food']) && is_numeric($data['qte'])) 
            {                
                $query = DbUtils::getPdo()->prepare('
                    INSERT INTO feeding 
                    (date_feeding, type_food, quantity, user_id, animal_id)
                    VALUES (:date_feeding, :type_food, :quantity, :user_id, :animal_id)
                    ');
                $query->bindValue('date_feeding', DbUtils::protectDbData(date('Y-m-d H:i:s')));
                $query->bindValue('type_food', DbUtils::protectDbData($data['food']));
                $query->bindValue('quantity', DbUtils::protectDbData($data['qte']), \PDO::PARAM_INT);
                $query->bindValue('user_id', DbUtils::protectDbData($_SESSION['user_id']));
                $query->bindValue('animal_id', DbUtils::protectDbData($data['animal']));
                
                
                if($query->execute()){
                    $data['id'] = DbUtils::getPdo()->lastInsertId();
                    $data['employee']= $_SESSION['user_id'];
                    $data['date']= date('Y-m-d H:i:s');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Le rapport a été créée avec success.',
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


    public function delete()
    {   
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);

        if (isset($request['id'])) {
            $query = DbUtils::getPdo()->prepare("DELETE FROM feeding WHERE id = :id");
            $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
            if ($query->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Rapport supprimé avec succès.',
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

    public function getInfo(){
        $query = DbUtils::getPdo()->query('SELECT * FROM animal');
        $data['animals'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        $query = DbUtils::getPdo()->query('SELECT * FROM users');
        $data['users'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Recuperations des datas OK',
            'data' => $data,
        ]);
    }
}

