<?php 
// require_once 'app/config/config.php';
use App\Database\DbUtils;
?>

<div class="container-fluid col-12 col-md-10 adm">
    <h1>Gestion des services</h1>
    <form method="post" action="" id="newService" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
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
                <th>Description</th>
                <th>Image</th>
                <th>Alt</th>
                <th></th>
            </tr>
        </thead>
        <tbody >
            <!--injection via php--> 
            <?php
            $query = DbUtils::getPdo()->query('SELECT * FROM service');
            $services = $query->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($services as $service) {
                echo '<tr data-id="' . $service['id'] . '">';
                echo '<td>' . $service['name'] . '</td>';
                echo '<td>' . $service['description'] . '</td>';
                echo '<td>' . $service['image_url']. '</td>';
                echo '<td>' . $service['image_alt'] . '</td>';
                echo '<td class="icon-cell">' .'<i class="bi bi-pencil-square"></i>'.'<i class="bi bi-trash" data-id="' . $service['id'] . '"></i>'.'<i class="bi bi-x-circle hidden"></i>'.'<i class="bi bi-floppy hidden"></i>' . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table> 
</div>