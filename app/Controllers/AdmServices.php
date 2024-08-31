<?php

namespace App\Controllers;
use App\Database\DbUtils;

class AdmServices
{
    public function injection(): string
    {
        // Get data from DB
        $query = DbUtils::getPdo()->query('SELECT * FROM service');
        $services = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        // Creat HTML for each service
        $html = '';
        foreach ($services as $service) {
            $html .= '<tr>';
            $html .= '<td>' . $service['name'] . '</td>';
            $html .= '<td>' . $service['description'] . '</td>';
            $html .= '<td>' . $service['image_url']. '</td>';
            $html .= '<td>' . $service['image_alt'] . '</td>';
            $html .= '<td>' . $service['image_alt'] . '</td>';
            $html .= '<td>' .'<i class="bi bi-pencil-square"></i>'.'<i class="bi bi-trash"></i>' . '</td>';
            $html .= '</tr>';
        }
        return $html;
    }

    public function managePostForm($post, $files)
    {
        if (isset($post['name']) ||
            isset($post['description']) ||
            isset($_FILE['upload']) ||
            isset($post['alt'])) 
            {
                $uploadDir = 'asset/uploads/'; 
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
        
                    $query->bindValue('name', DbUtils::protectDbData($post['name']));
                    $query->bindValue('description', DbUtils::protectDbData($post['description']));
                    $query->bindValue('upload', $uploadFile);
                    $query->bindValue('alt', DbUtils::protectDbData($post['alt']));
                    $query->execute();
            
                    echo "upload reussi.";
                
                } else {
                    echo "Erreur lors de l'upload du fichier.";
                }
            } else {
                echo "Le fichier n'est pas une image.";
            }
            
        } else {
            echo 'Champs vide. Insertion impossible !';
        }
    }
}