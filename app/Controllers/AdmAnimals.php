<?php
namespace App\Controllers;
use App\Database\DbUtils;

class AdmAnimals
{   
    public function view()
    {   
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'){
                return __DIR__.'/../Views/admAnimals.php';
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
            isset($data['breed']) &&
            isset($data['biome']) &&
            isset($_FILES['upload']) &&
            isset($data['alt'])) 
            {
                $uploadDir = 'asset/images/animals/'; 
                $uploadFile = $uploadDir . basename($files['upload']['name']);
                
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $check = getimagesize($files['upload']['tmp_name']);
                
                if($check) {
                    if (move_uploaded_file($files['upload']['tmp_name'], $uploadFile)) 
                    {
                        $query = DbUtils::getPdo()->prepare('INSERT INTO animal
                            (name, breed_id, biome_id, image_url, image_alt)
                            VALUES (
                                :name,
                                :breed,
                                :biome,
                                :upload,
                                :alt
                            )
                        ');
                        $data['upload'] = '/' . $uploadFile;
                        $query->bindValue('name', DbUtils::protectDbData($data['name']));
                        $query->bindValue('breed', DbUtils::protectDbData($data['breed']));
                        $query->bindValue('biome', DbUtils::protectDbData($data['biome']));
                        $query->bindValue('upload', DbUtils::protectDbData($data['upload']));
                        $query->bindValue('alt', DbUtils::protectDbData($data['alt']));
                        
                        if($query->execute()){
                            // $data['id'] = DbUtils::getPdo()->lastInsertId();
                            echo json_encode([
                                'success' => true,
                                'message' => 'L\'animal a été enregistré avec success.',
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
        
        if (isset($request['id'], $request['name'], $request['breed'], $request['biome'], $request['image_url'], $request['image_alt'])) {
            $query = DbUtils::getPdo()->prepare("UPDATE animal SET name = :name , breed_id = :breed, biome_id = :biome , image_url = :image_url, image_alt = :image_alt WHERE id = :id");
            
            $query->bindValue(':id', DbUtils::protectDbData($request['id']));
            $query->bindValue(':name', DbUtils::protectDbData($request['name']));
            $query->bindValue(':breed', DbUtils::protectDbData($request['breed']));
            $query->bindValue(':biome', DbUtils::protectDbData($request['biome']));
            $query->bindValue(':image_url', DbUtils::protectDbData($request['image_url']));
            $query->bindValue(':image_alt', DbUtils::protectDbData($request['image_alt']));
    
            $query->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Information sur l\'animal modifié avec succès.',
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
            $query = DbUtils::getPdo()->prepare('SELECT image_url FROM animal WHERE id = :id');
            $query -> bindValue(':id', $request['id'], \PDO::PARAM_INT);
            if ($query->execute()) {
                $image = $query->fetch(\PDO::FETCH_ASSOC);
            }
            if ($image && !empty($image['image_url']) && file_exists(ltrim($image['image_url'], '/')))
            {
                // delete
                $query = DbUtils::getPdo()->prepare("DELETE FROM animal WHERE id = :id");
                $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
        
                if ($query->execute()) {
                    // delete images
                    echo json_encode([
                        'success' => true,
                        'message' => 'Enregistrement de l\'animal supprimé avec succès.',
                    ]);
                    unlink(ltrim($image['image_url'], '/')); 
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

    
    public function getBreedBiome(){
        $query = DbUtils::getPdo()->query('SELECT * FROM breed ORDER BY name ASC');
        $data['breeds'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        $query = DbUtils::getPdo()->query('SELECT * FROM biome ORDER BY name ASC');
        $data['biomes'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Recuperations des datas OK',
            'data' => $data,
        ]);
    }
    
    public function test(){
        // var_dump($image['image_url']);
        // var_dump($image['image_url_hd']);
    }

}
