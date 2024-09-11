<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmUsers
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'){
                return __DIR__.'/../Views/admUsers.php';
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
        
        if (isset($request['id'], $request['role'])) {
            $id = $request['id'];
            $role = $request['role'];
            
            $query = DbUtils::getPdo()->prepare("UPDATE users SET role_id = :role WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($request['id']));
            $query->bindValue('role', DbUtils::protectDbData($request['role']));
            $query->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Droit modifié',
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
            $query = DbUtils::getPdo()->prepare("DELETE FROM users WHERE id = :id");
            $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
            if ($query->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Utilisateur supprimé avec succès.',
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

    public function post($data)
    {   
        header('Content-Type: application/json');
        if (isset($data['name']) &&
            isset($data['forename']) &&
            isset($data['email']) &&
            isset($data['password']) &&
            isset($data['role'])) 
            {   
                $query = DbUtils::getPdo()->query('SELECT * FROM role');
                $users = $query->fetchAll(\PDO::FETCH_ASSOC);
                $data['roles'] = $users; // I need it for update the table with js
                
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

                $query = DbUtils::getPdo()->prepare('INSERT INTO users
                    (name, forename, email, password, role_id)
                    VALUES (
                        :name,
                        :forename,
                        :email,
                        :password,
                        :role_id
                    )
                ');
                $query->bindValue('name', DbUtils::protectDbData($data['name']));
                $query->bindValue('forename', DbUtils::protectDbData($data['forename']));
                $query->bindValue('email', DbUtils::protectDbData($data['email']));
                $query->bindValue('password', DbUtils::protectDbData($data['password']));
                $query->bindValue('role_id', DbUtils::protectDbData($data['role']));
                
                if($query->execute()){
                    $newUserId = DbUtils::getPdo()->lastInsertId();
                    echo json_encode([
                        'success' => true,
                        'message' => 'L\'utilisateur a été créé.',
                        'data' => array_merge($data, ['id' => $newUserId]),
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
            }
            else {
            echo json_encode([
                'success' => false,
                'message' => 'Champs vide. Insertion impossible !'
            ]);
            exit();
        }
    }
}
