<?php
require_once __DIR__ . '/../../vendor/autoload.php';
// namespace App\Controllers;

use App\Database\DbUtils;

class UpdateService
{
    public function update($post)
    {
        if (isset($post['id'], $post['name'], $post['description'], $post['image_url'], $post['image_alt'])) {
            $id = $post['id'];
            $name = $post['name'];
            $description = $post['description'];
            $url = $post['image_url'];
            $alt = $post['image_alt'];

            $query = DbUtils::getPdo()->prepare("UPDATE service SET name = :name , description = :description , image_url = :image_url , image_alt = :image_alt WHERE id = :id");
            $query->bindValue('id', DbUtils::protectDbData($post['id']));
            $query->bindValue('name', DbUtils::protectDbData($post['name']));
            $query->bindValue('description', DbUtils::protectDbData($post['description']));
            $query->bindValue('image_url', DbUtils::protectDbData($post['image_url']));
            $query->bindValue('image_alt', DbUtils::protectDbData($post['image_alt']));
            $query->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}

// Instancier l'objet et appeler la méthode update
$updateService = new UpdateService();
$updateService->update($_POST);