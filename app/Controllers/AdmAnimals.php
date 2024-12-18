<?php
namespace App\Controllers;
use App\Database\DbUtils;
use App\Database\Mongo;

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
                $fileExtension = strtolower(pathinfo($files['upload']['name'], PATHINFO_EXTENSION));
                $newFileName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $newFileName;

                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $maxFileSize = 5 * 1024 * 1024; // 5 MB

                if (!in_array($fileExtension, $allowedTypes)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Type de fichier non autorisé. Utilisez JPG, JPEG, PNG ou GIF.'
                    ]);
                    exit();
                }

                if ($files['upload']['size'] > $maxFileSize) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Le fichier est trop volumineux. Taille maximale : 5 MB.'
                    ]);
                    exit();
                }

                $check = getimagesize($files['upload']['tmp_name']);
                
                if($check) {
                    if (move_uploaded_file($files['upload']['tmp_name'], $uploadFile)) 
                    {   
                        $queryBreed = DbUtils::getPdo()->prepare('SELECT name FROM breed WHERE id = :breed_id');
                        $queryBreed->bindValue('breed_id', DbUtils::protectDbData($data['breed']));
                        $queryBreed->execute();
                        $breedResult = $queryBreed->fetch(\PDO::FETCH_ASSOC);

                        $queryBiome = DbUtils::getPdo()->prepare('SELECT name FROM biome WHERE id = :biome_id');
                        $queryBiome->bindValue('biome_id', DbUtils::protectDbData($data['biome']));
                        $queryBiome->execute();
                        $biomeResult = $queryBiome->fetch(\PDO::FETCH_ASSOC);


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
                            $data['id'] = DbUtils::getPdo()->lastInsertId();
                            $data['breed_name'] = $breedResult['name'];
                            $data['biome_name'] = $biomeResult['name'];

                            // add in Mongo
                            $mongo = new Mongo();
                            $mongo->addAnimal($data['name']);
                            // 

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
            
            // get name for mongo
            $nameQuery = DbUtils::getPdo()->prepare("SELECT name FROM animal WHERE id = :id");
            $nameQuery ->bindValue(':id', $request['id'], \PDO::PARAM_INT);
            $nameQuery->execute();
            $nameResult = $nameQuery->fetch(\PDO::FETCH_ASSOC);

            $mongo = new Mongo();
            $mongo->updateAnimal($nameResult['name'], $request['name']);


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
                // get name for mongo
                $nameQuery = DbUtils::getPdo()->prepare("SELECT name FROM animal WHERE id = :id");
                $nameQuery ->bindValue(':id', $request['id'], \PDO::PARAM_INT);
                $nameQuery->execute();
                $nameResult = $nameQuery->fetch(\PDO::FETCH_ASSOC);
                // delete
                $query = DbUtils::getPdo()->prepare("DELETE FROM animal WHERE id = :id");
                $query->bindValue(':id', $request['id'], \PDO::PARAM_INT);
        
                if ($query->execute()) {
                    // delete images


                    // add in Mongo

                    $mongo = new Mongo();
                    $mongo->deleteAnimal($nameResult['name']);
                    // 
                    
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
}
