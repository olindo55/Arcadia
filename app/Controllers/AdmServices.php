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

    public function managePostForm($post)
    {
        if (isset($post['name']) ||
            isset($post['description']) ||
            // isset($_FILE['upload']) ||
            isset($post['alt'])) 
            {
                $query = DbUtils::getPdo()->prepare('INSERT INTO service
                    (name, description/*, image_url*/, image_alt)
                    VALUES (
                        :name,
                        :description,
                        -- :upload,
                        :alt
                    )
                ');
        
                $query->bindValue('name', DbUtils::protectDbData($post['name']));
                $query->bindValue('description', DbUtils::protectDbData($post['description']));
                // $query->bindParam('upload', $post['upload']);
                $query->bindValue('alt', DbUtils::protectDbData($post['alt']));
                $query->execute();
        
                // header('Location: /adm-services');
                
            } else  {
                echo 'Champs vide. Insertion impossible !';
            }
    }
}
