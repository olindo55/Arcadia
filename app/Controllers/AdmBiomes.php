<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmBiomes
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'){
                return __DIR__.'/../Views/admBiomes.php';
        }
        else{
            $_SESSION['flash_message'] = 'Accès non autorisé';
            $_SESSION['flash_alert'] = 'danger';
            return __DIR__.'/../Views/homepage.php';
        }
    }

    public function post(array $data, $files)
    {   
        header('Content-Type: application/json');
        if (isset($data['name']) &&
            isset($data['description']) &&
            isset($_FILES['upload']) &&
            isset($_FILES['upload_hd']) &&
            isset($data['alt'])) 
            {
                $uploadDir = 'asset/images/biome/'; 
                $uploadFile = $uploadDir . basename($files['upload']['name']);
                $uploadFileHD = $uploadDir .'high-resolution/'. basename($files['upload_hd']['name']);
                
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $check = getimagesize($files['upload']['tmp_name']);
                $checkHD = getimagesize($files['upload_hd']['tmp_name']);
                
                if($check && $checkHD) {
                    if (move_uploaded_file($files['upload']['tmp_name'], $uploadFile)
                        && move_uploaded_file($files['upload_hd']['tmp_name'], $uploadFileHD)) 
                    {
                        $query = DbUtils::getPdo()->prepare('INSERT INTO biome
                            (name, description, image_url, image_url_hd, image_alt)
                            VALUES (
                                :name,
                                :description,
                                :upload,
                                :upload_hd,
                                :alt
                            )
                        ');
                        $data['upload'] = '/' . $uploadFile;
                        $data['upload_hd'] = '/' . $uploadFileHD;
                        $query->bindValue('name', DbUtils::protectDbData($data['name']));
                        $query->bindValue('description', DbUtils::protectDbData($data['description']));
                        $query->bindValue('upload', DbUtils::protectDbData($data['upload']));
                        $query->bindValue('upload_hd', DbUtils::protectDbData($data['upload_hd']));
                        $query->bindValue('alt', DbUtils::protectDbData($data['alt']));
                        
                        if($query->execute()){
                            $data['id'] = DbUtils::getPdo()->lastInsertId();
                            echo json_encode([
                                'success' => true,
                                'message' => 'Le service a été créé.',
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
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Le fichier n\'est pas une image.'
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

    public function put()
    {
        $requestJSON = trim(file_get_contents("php://input"));
        $request = json_decode($requestJSON, true);
        
        if (isset($request['id'], $request['name'], $request['description'], $request['image_url'], $request['image_url_hd'], $request['image_alt'])) {
            $id = $request['id'];
            $name = $request['name'];
            $description = $request['description'];
            $url = $request['image_url'];
            $url_hd = $request['image_url_hd'];
            $alt = $request['image_alt'];

            $query = DbUtils::getPdo()->prepare("UPDATE biome SET name = :name , description = :description , image_url = :image_url , image_url_hd = :image_url_hd , image_alt = :image_alt WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($request['id']));
            $query->bindValue('name', DbUtils::protectDbData($request['name']));
            $query->bindValue('description', DbUtils::protectDbData($request['description']));
            $query->bindValue('image_url', DbUtils::protectDbData($request['image_url']));
            $query->bindValue('image_url_hd', DbUtils::protectDbData($request['image_url_hd']));
            $query->bindValue('image_alt', DbUtils::protectDbData($request['image_alt']));
            $query->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Habitat modifié avec succès.',
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
            // get url of images
            $query = DbUtils::getPdo()->prepare('SELECT image_url, image_url_hd FROM biome WHERE id = :id');
            $query -> bindValue(':id', $request['id'], \PDO::PARAM_INT);
            if ($query->execute()) {
                $image = $query->fetch(\PDO::FETCH_ASSOC);
            }
            if ($image && !empty($image['image_url']) && file_exists(ltrim($image['image_url'], '/'))
                 && !empty($image['image_url_hd']) && file_exists(ltrim($image['image_url_hd'], '/')))
            {
                // delete
                $query = DbUtils::getPdo()->prepare("DELETE FROM biome WHERE id = :id");
                $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
        
                if ($query->execute()) {
                    // delete images
                    echo json_encode([
                        'success' => true,
                        'message' => 'Habitat supprimé avec succès.',
                    ]);
                    unlink(ltrim($image['image_url'], '/'));
                    unlink(ltrim($image['image_url_hd'], '/')); 
                } else {
                    echo json_encode([
                        'success' => false, 
                        'message' => 'Erreur du serveur lors de l\'exécution de la requête',
                    ]);
                }
            }
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Paramètre manquant',
            ]);
        }
    }

    public function test(){
        var_dump($image['image_url']);
        var_dump($image['image_url_hd']);
    }

}
