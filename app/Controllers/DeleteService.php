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
 
             try {
                // Obtenez une instance de PDO
                $pdo = DbUtils::getPdo();

                // Préparez la requête SQL
                $stmt = $pdo->prepare("DELETE FROM service WHERE id = :id");

                // Liez le paramètre ID correctement
                $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

                // Exécutez la requête
                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Erreur lors de la suppression']);
                }
            } catch (\PDOException $e) {
                // En cas d'erreur PDO
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'ID manquant ou méthode incorrecte']);
        }
        // echo "test.";
        // $method = $post['_method'] ?? null;
        // if ($method === 'DELETE') {
        //     if (isset($post['id'])) {
        //         $query = DbUtils::getPdo()->prepare('DELETE FROM service WHERE id = :id');
        //         $query->bindValue('id', $post['id']);

        //         if ($query->execute()) {
        //             return json_encode(['success' => true]);
        //         } else {
        //             return json_encode(['success' => false]);
        //         }
        //     } else {
        //         return json_encode(['success' => false]);
        //     }
        // }
    }
}

// Instancier l'objet et appeler la méthode delete
$deleteService = new DeleteService();
$deleteService->delete($_POST);
