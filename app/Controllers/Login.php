<?php
namespace App\Controllers;
use App\Database\DbUtils;
use PDO;

class Login
{   
    function signout(){
        unset($_SESSION['connected']);
        unset( $_SESSION['role']);
        $_SESSION['flash_message'] = 'Vous êtes désormais déconnecté(e)';
        $_SESSION['flash_alert'] = 'success';
        return __DIR__.'/../Views/homepage.php';
    }

    function check($data){
        if (!$data['email'] || !$data['password']) {
            echo json_encode([
                'success' => false,
                'message' => 'Email ou mot de passe incorrect',
            ]);
            exit();

        } else {
            $query = DbUtils::getPdo()->prepare(
                'SELECT u.id, u.name, u.forename, u.email, u.password, r.role
                FROM users u
                JOIN role r ON u.role_id = r.id
                WHERE u.email = :email');
            $query->bindParam('email', $data['email']);
            $query->execute();
    
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email ou mot de passe incorrect',
                ]);
                exit();

            } else {
                $passwordOk = password_verify($data['password'], $user['password']);

                if (!$passwordOk) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Email ou mot de passe incorrect',
                    ]);
                    exit();

                } else {
                    unset($user['password']);
                    $_SESSION['connected'] = true;
                    $_SESSION['role'] = $user['role'];
                    if (preg_match('/^[aeiouyAEIOUY]/', $_SESSION['role'])){
                        $message = 'Bonjour '. ', vous êtes désormais connecté(e) en tant qu\''. $_SESSION['role']. '.';
                    }else{
                        'Bonjour '. ', vous êtes désormais connecté(e) en tant que '. $_SESSION['role']. '.';
                    }
                    $_SESSION['flash_message'] = $message;
                    $_SESSION['flash_alert'] = 'success';
                    echo json_encode([
                        'success' => true,
                        'message' => $message,
                    ]);
                    exit();
                }
            }
        }  
    }

    // public function check($data)
    // {
    //     $query = DbConnection::getPdo()->prepare('SELECT * FROM user WHERE username = :username');
    //     $query->bindParam('username', $_POST['username']);
    //     $query->execute();

    //     $_SESSION['connected'] = false;
    //     echo json_encode([
    //         'success' => false,
    //         'message' => 'Email ou mot de passe incorrect',
    //     ]);

    //     foreach ($users as $user) {
    //         if($user['email'] === $data['email'] && password_verify($data['password'], $user['password']))
    //         {
    //             $_SESSION['connected'] = true;
    //             echo json_encode([
    //                 'success' => true,
    //                 'message' => 'Bonjour '. $user['forename'] . ', vous êtes désormais connecté(e)',
    //             ]);
    //             break;
    //         }
    //     }
    // }
}  