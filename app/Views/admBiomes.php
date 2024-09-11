<?php 
use App\Database\DbUtils;
?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des habitats</h1>
        <form method="post" action="" id="biomeForm" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
            <fieldset>
            <legend>Ajouter un habitat</legend>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
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
                    <label for="upload_hd" class="form-label">Télécharger une image HD</label>
                    <input class="form-control form-control-sm" id="upload_hd" name="upload_hd" type="file">
                </div>
                <div class="mb-3">
                    <label for="alt" class="form-label">Texte alternatif de l'image</label>
                    <input type="text" class="form-control" id="alt" name="alt" maxlength="250" required>
                </div>
            </fieldset>
            <button type="submit" id="addBiomeButton" class="btn btn-primary">Ajouter</button>
        </form>

        <!-- <input type="text" id="search" placeholder="Recherche..."> -->
        <h2>Les habitats publiés</h2>
        <div class="table-responsive">
            <table id="list-biome"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <th id="sort-name"><i id="sort-icon" class="bi bi-sort-down"></i> Nom</th> 
                        <th>Description</th>
                        <th>Image</th>
                        <th>Image HD</th>
                        <th>Alt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php
                    $query = DbUtils::getPdo()->query('SELECT * FROM biome');
                    $biomes = $query->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($biomes as $biome) {
                        echo '<tr data-id="' . $biome['id'] . '">';
                        echo '<td>' . $biome['name'] . '</td>';
                        echo '<td>' . $biome['description'] . '</td>';
                        echo '<td>' . $biome['image_url']. '</td>';
                        echo '<td>' . $biome['image_url_hd']. '</td>';
                        echo '<td>' . $biome['image_alt'] . '</td>';
                        echo '<td class="icon-cell">' 
                            . '<i class="bi bi-pencil-square"></i>'
                            . '<i class="bi bi-trash" data-id="' . $biome['id'] . '"></i>'
                            .'<i class="bi bi-x-circle hidden"></i>'
                            . '<i class="bi bi-floppy hidden"></i>' 
                            . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>