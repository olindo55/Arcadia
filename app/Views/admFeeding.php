<?php 
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM animal ORDER BY name ASC');
$animals = $query->fetchAll(\PDO::FETCH_ASSOC);

?>
    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Nourrissage</h1>
        <form method="post" action="" id="admForm" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
            <fieldset>
            <legend>Ajout nourrissage</legend>
                <div class="mb-3">
                    <label for="animal" class="form-label">Animal</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" name="animal">
                            <?php foreach ($animals as $animal) {
                                    echo '<option value="' . $animal['id'] . '">' . $animal['name'] . '</option>';
                                } 
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="qte" class="form-label">Quantité en gr.</label>
                    <input type="number" class="form-control" id="qte" name="qte" required>
                </div>
                <div class="mb-3">
                    <label for="food" class="form-label">Nourriture</label>
                    <input type="text" class="form-control" id="food" name="food" maxlength="50" required>
                </div>
            </fieldset>
            <button type="submit" id="addFoodButton" class="btn btn-primary">Ajouter</button>
        </form>

    <div class="container-fluid col-12 col-md-10 adm">
        <h2>Rapports de nourrissage</h2>
        <div class="table-responsive">
            <table id="list-feeding"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <th><i id="sort-icon-animal" class="bi bi-sort-down"></i> Animal </th>
                        <th><i id="sort-icon-qte" class="bi bi-sort-down"></i> Quantité en gr </th>
                        <th><i id="sort-icon-food" class="bi bi-sort-down"></i> Nourriture </th>
                        <th><i id="sort-icon-date" class="bi bi-sort-down"></i> Date </th>
                        <th><i id="sort-icon-employee" class="bi bi-sort-down"></i> Employé(e) </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php
                    $query = DbUtils::getPdo()->query('
                        SELECT f.id, f.date_feeding, f.type_food, f.quantity, u.name, u.forename, a.name as animal
                        FROM feeding f 
                        LEFT JOIN users u ON f.user_id = u.id
                        JOIN animal a ON f.animal_id = a.id
                        ORDER BY f.date_feeding DESC'
                    );
                    $feed = $query->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($feed as $food) {
                        echo '<tr data-id="' . $food['id'] . '">';

                        echo '<td>' . $food['animal'] . '</td>';
                        echo '<td>' . $food['quantity']. '</td>';
                        echo '<td>' . $food['type_food'] . '</td>';
                        echo '<td>' . $food['date_feeding'] . '</td>';
                        echo '<td>' . $food['name'] . ' ' . $food['forename'] . '</td>';

                        echo '<td class="icon-cell">' 
                            . '<i class="bi bi-trash" data-id="' . $food['id'] . '"></i>'
                            . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table> 
        </div>
    </div>