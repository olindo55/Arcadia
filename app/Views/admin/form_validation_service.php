<?php
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    if (!$_POST['name'] ||
        !$_POST['description'] ||
        // !$_POST['upload'] ||
        !$_POST['alt']
    ) {
        echo 'Champs vide. Insertion impossible !';
    } else  {
        $query = DbConnection::getPdo()->prepare('INSERT INTO service
            (name, description/*, image_url*/, image_alt)
            VALUES (
                :name,
                :description,
                -- :upload,
                :alt
            )
        ');

        $query->bindValue('name', DbConnection::protectDbData($_POST['name']));
        $query->bindValue('description', DbConnection::protectDbData($_POST['description']));
        // $query->bindParam('upload', $_POST['upload']);
        $query->bindParam('alt', $_POST['alt']);
        $query->execute();

        header('Location: /adm-services');
    }
} 
