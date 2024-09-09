<?php
namespace App\Controllers;
use App\Database\DbUtils;
use PDO;

class Login
{
    function check($data){
        if (!$data['email'] || !$data['password']) {
            echo json_encode([
                'success' => false,
                'message' => '1Email ou mot de passe incorrect',
            ]);
            exit();

        } else {
            $query = DbUtils::getPdo()->prepare('SELECT * FROM users WHERE email = :email');
            $query->bindParam('email', $data['email']);
            $query->execute();
    
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => '2Email ou mot de passe incorrect',
                ]);
                exit();

            } else {
                $passwordOk = password_verify($data['password'], $user['password']);

                if (!$passwordOk) {
                    echo json_encode([
                        'success' => false,
                        'message' => '3Email ou mot de passe incorrect',
                    ]);
                    exit();

                } else {
                    unset($user['password']);
                    $_SESSION['connected'] = true;
                    $_SESSION['flash_message'] = 'Bonjour '. $user['forename'] . ', vous êtes désormais connecté(e)';
                    $_SESSION['flash_alert'] = 'success';
                    echo json_encode([
                        'success' => true,
                        'message' => 'Bonjour '. $user['forename'] . ', vous êtes désormais connecté(e)',
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