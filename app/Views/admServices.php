<?php
require_once 'app/config/config.php' ?>

<div class="container-fluid col-12 col-md-10 adm">
    <h1>Gestion des services</h1>
    <form method="post" action="index.php?page=admServices" id="newService" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
        <fieldset>
        <legend>Ajouter un service</legend>
            <div class="mb-3">
                <label for="name" class="form-label">Nom du service</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="upload" class="form-label">Télécharger une image</label>
                <input class="form-control form-control-sm" id="upload" name="upload" type="file">
            </div>
            <div class="mb-3">
                <label for="alt" class="form-label">Texte alternatif de l'image</label>
                <input type="text" class="form-control" id="alt" name="alt" maxlength="250" required>
            </div>
        </fieldset>
        <button type="submit" id="addServicetButton" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- <input type="text" id="search" placeholder="Recherche..."> -->
     <h2>Les services diffusés</h2>
    <table id="list-service"  class="table table-hover table-responsive">
        <thead>
            <tr class="table-primary ">
                <th id="sort-name"><i id="sort-icon" class="bi bi-sort-alpha-down"></i> Nom</th> 
                <!-- <i class="bi bi-sort-alpha-down-alt"></i> -->
                <th>Description</th>
                <th>Image</th>
                <th>Alt</th>
                <th></th>
            </tr>
        </thead>
        <tbody >
            <!--injection via php--> 
            <?php
                $pageName = $_GET['page'] ?? 'home';
                $controllerName = 'App\\Controllers\\'.ucfirst($pageName);
                $controller = new $controllerName;
                $result = $controller->injection();
                echo $result;
            ?>
        </tbody>
    </table>
</div>
<!-- <script type="module" src="/asset/js/admin/services.js"></script> -->
