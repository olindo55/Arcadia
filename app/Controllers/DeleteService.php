<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// namespace App\Controllers;

use App\Database\DbUtils;

class DeleteService
{
    public function delete($post)
    {   
         header('Content-Type: application/json'); 
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($post['id'])) {
             $id = $post['id'];
 
                $query = DbUtils::getPdo()->prepare("DELETE FROM service WHERE id = :id");
                $query->bindValue(':id', $id, \PDO::PARAM_INT);

                if ($query->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Erreur lors de la suppression']);
                }
        } else {
            echo json_encode(['success' => false, 'error' => 'ID manquant ou méthode incorrecte']);
        }
    }
}

// Instancier l'objet et appeler la méthode delete
$deleteService = new DeleteService();
$deleteService->delete($_POST);
