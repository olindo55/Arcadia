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
            $html .= '<tr data-id="' . $service['id'] . '">';
            $html .= '<td>' . $service['name'] . '</td>';
            $html .= '<td>' . $service['description'] . '</td>';
            $html .= '<td>' . $service['image_url']. '</td>';
            $html .= '<td>' . $service['image_alt'] . '</td>';
            $html .= '<td class="icon-cell">' .'<i class="bi bi-pencil-square"></i>'.'<i class="bi bi-trash" data-id="' . $service['id'] . '"></i>'.'<i class="bi bi-x-circle hidden"></i>'.'<i class="bi bi-floppy hidden"></i>' . '</td>';
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
            
                    echo  "upload reussi";
                
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

    public function update()
    {
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);
        
        if (isset($request['id'], $request['name'], $request['description'], $request['image_url'], $request['image_alt'])) {
            $id = $request['id'];
            $name = $request['name'];
            $description = $request['description'];
            $url = $request['image_url'];
            $alt = $request['image_alt'];

            $query = DbUtils::getPdo()->prepare("UPDATE service SET name = :name , description = :description , image_url = :image_url , image_alt = :image_alt WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($request['id']));
            $query->bindValue('name', DbUtils::protectDbData($request['name']));
            $query->bindValue('description', DbUtils::protectDbData($request['description']));
            $query->bindValue('image_url', DbUtils::protectDbData($request['image_url']));
            $query->bindValue('image_alt', DbUtils::protectDbData($request['image_alt']));
            $query->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur du serveur lors de l\'exécution de la requête']);
        }
    }

    public function delete()
    {   
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);

        if (isset($request['id'])) {
            $query = DbUtils::getPdo()->prepare("DELETE FROM service WHERE id = :id");
            $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
    
            if ($query->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erreur du serveur lors de l\'exécution de la requête']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Paramètre manquant']);
        }
    }
}

