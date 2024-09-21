<?php

namespace App\Controllers;
use App\Database\DbUtils;

class Homepage
{
    public function view()
    {
        return __DIR__.'/../Views/homepage.php';
    }

    public function post($data){
        header('Content-Type: application/json');
        if (isset($data['pseudo']) &&
            isset($data['comment']) &&
            isset($data['ratingValue'])) 
            {
                $query = DbUtils::getPdo()->prepare('INSERT INTO comment
                    (pseudo, comment, date_comment, score, published)
                    VALUES (
                        :pseudo,
                        :comment,
                        NOW(),
                        :score,
                        false
                    )
                ');
                $score = $data['ratingValue'];
                if ($score < 1 || $score > 5) {
                    $score = 1;
                }
                $query->bindValue('pseudo', DbUtils::protectDbData($data['pseudo']));
                $query->bindValue('comment', DbUtils::protectDbData($data['comment']));
                $query->bindValue('score', DbUtils::protectDbData($score));
                
                if($query->execute()){
                    echo json_encode([
                        'success' => true,
                        'message' => 'Le commentaire a été envoyé.',
                    ]);
                    exit();
                }else{
                    echo json_encode([
                        'success' => false,
                        'message' => 'Une erreur est survenue lors de l\'envoie de votre commentaire.',
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
    
}