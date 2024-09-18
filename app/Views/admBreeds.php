<?php 
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM dietary ORDER BY name ASC');
$diets = $query->fetchAll(\PDO::FETCH_ASSOC);

?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des races</h1>
        <form method="post" action="" id="admForm" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
            <fieldset>
            <legend>Ajouter une race</legend>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <label for="diet" class="form-label">Régime alimentaire</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" name="diet">
                            <?php foreach ($diets as $diet) {
                                    echo '<option value="' . $diet['id'] . '">' . $diet['name'] . '</option>';
                                } 
                            ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <button type="submit" id="addBreedButton" class="btn btn-primary">Ajouter</button>
        </form>

        <!-- <input type="text" id="search" placeholder="Recherche..."> -->
        <h2>Les races disponibles</h2>
        <div class="table-responsive">
            <table id="list-breed"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <!-- <th id="sort-name"><i id="sort-icon-name" class="bi bi-sort-down"></i>Name</th>  -->
                        <th><i id="sort-icon-name" class="bi bi-sort-down"></i>Name</th> 
                        <th><i id="sort-icon-diet" class="bi bi-sort-down"></i>Régime alimentaire</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php
                    $query = DbUtils::getPdo()->query('SELECT * FROM breed');
                    $breeds = $query->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($breeds as $breed) {
                        echo '<tr data-id="' . $breed['id'] . '">';
                        echo '<td>' . $breed['name'] . '</td>';
                        echo '<td>' . $breed['diet'] . '</td>';
                        echo '<td class="icon-cell">' 
                            . '<i class="bi bi-pencil-square"></i>'
                            . '<i class="bi bi-trash" data-id="' . $breed['id'] . '"></i>'
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