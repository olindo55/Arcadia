<?php 
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM breed ORDER BY name ASC');
$breeds = $query->fetchAll(\PDO::FETCH_ASSOC);

$query = DbUtils::getPdo()->query('SELECT * FROM biome ORDER BY name ASC');
$biomes = $query->fetchAll(\PDO::FETCH_ASSOC);

?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des animaux</h1>
        <form method="post" action="" id="admForm" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
            <fieldset>
            <legend>Ajouter un animal</legend>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <label for="breed" class="form-label">Race</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" name="breed">
                            <?php foreach ($breeds as $breed) {
                                    echo '<option value="' . $breed['id'] . '">' . $breed['name'] . '</option>';
                                } 
                            ?>
                        </select>
                        <a href="/admBreeds/view">
                            <i class="bi bi-plus-circle m-2 fs-4"></i>
                        </a>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="biome" class="form-label">Habitat</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" name="biome">
                            <?php foreach ($biomes as $biome) {
                                    echo '<option value="' . $biome['id'] . '">' . $biome['name'] . '</option>';
                                } 
                            ?>
                        </select>
                        <a href="/admBiomes/view">
                            <i class="bi bi-plus-circle m-2 fs-4"></i>
                        </a>
                    </div>
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
            <button type="submit" id="addBiomeButton" class="btn btn-primary">Ajouter</button>
        </form>

        <!-- <input type="text" id="search" placeholder="Recherche..."> -->
        <h2>Les animaux publiés</h2>
        <div class="table-responsive">
            <table id="list-animal"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <!-- <th id="sort-name"><i id="sort-icon-name" class="bi bi-sort-down"></i>Name</th>  -->
                        <th><i id="sort-icon-name" class="bi bi-sort-down"></i>Name</th> 
                        <th><i id="sort-icon-breed" class="bi bi-sort-down"></i>Race</th>
                        <th><i id="sort-icon-biome" class="bi bi-sort-down"></i>Habitat</th>
                        <th>Image</th>
                        <th>Alt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php
                    $query = DbUtils::getPdo()->query('SELECT a.id, a.name, a.image_url, a.image_alt, br.name as race, bi.name as biome
                                                     FROM animal a
                                                     JOIN breed br ON a.breed_id = br.id
                                                     JOIN biome bi ON a.biome_id = bi.id');
                    $animals = $query->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($animals as $animal) {
                        echo '<tr data-id="' . $animal['id'] . '">';
                        echo '<td>' . $animal['name'] . '</td>';
                        echo '<td>' . $animal['race'] . '</td>';
                        echo '<td>' . $animal['biome']. '</td>';
                        echo '<td>' . $animal['image_url']. '</td>';
                        echo '<td>' . $animal['image_alt'] . '</td>';
                        echo '<td class="icon-cell">' 
                            . '<i class="bi bi-pencil-square"></i>'
                            . '<i class="bi bi-trash" data-id="' . $animal['id'] . '"></i>'
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