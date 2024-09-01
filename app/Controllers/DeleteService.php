<?php

namespace App\Controllers;

use App\Database\DbUtils;

class DeleteService
{
    public function delete($post)
    {
        echo "test.";
        $method = $post['_method'] ?? null;
        if ($method === 'DELETE') {
            if (isset($post['id'])) {
                $query = DbUtils::getPdo()->prepare('DELETE FROM service WHERE id = :id');
                $query->bindValue('id', $post['id']);

                if ($query->execute()) {
                    return json_encode(['success' => true]);
                } else {
                    return json_encode(['success' => false]);
                }
            } else {
                return json_encode(['success' => false]);
            }
        }
    }
}

// Instancier l'objet et appeler la méthode delete
$deleteService = new DeleteService();
$deleteService->delete($_GET['id']);
