<?php
namespace App\Controllers;
use App\Database\DbUtils;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $alt = $_POST['alt'] ?? null;

    if ($id && $name && $description && $alt) {
        try {
            $query = DbUtils::getPdo()->prepare('UPDATE service SET name = :name, description = :description, image_alt = :alt WHERE id = :id');
            $query->bindValue('id', $id, \PDO::PARAM_INT);
            $query->bindValue('name', DbUtils::protectDbData($name));
            $query->bindValue('description', DbUtils::protectDbData($description));
            $query->bindValue('alt', DbUtils::protectDbData($alt));

            if ($query->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
