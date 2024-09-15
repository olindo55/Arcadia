<?php 
use App\Database\DbUtils;


$query = DbUtils::getPdo()->query('
    SELECT u.id, u.name, u.forename, u.email, r.role
    FROM users u
    JOIN role r ON u.role_id = r.id
    ');
$users = $query->fetchAll(\PDO::FETCH_ASSOC);

$query = DbUtils::getPdo()->query('
    SELECT *
    FROM role
    ORDER BY role ASC
    ');
$roles = $query->fetchAll(\PDO::FETCH_ASSOC);

?>
        <div class="container-fluid col-12 col-md-10 adm">
            <h1>Gestion des utilisateurs</h1>
            <form method="post" action="" id="admForm" class="container-fluid col-12 col-lg-6 col-md-10" enctype="multipart/form-data">
                <fieldset>
                <legend>Ajouter un utilisateur</legend>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="forename" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="forename" name="forename" maxlength="50" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="250" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" maxlength="60" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Droits</label>
                        <select class="form-select" name="role">
                            <?php foreach ($roles as $role) {
                                    $selected = ($role['role'] == 'employé') ? 'selected' : '';
                                    echo '<option value="' . $role['id'] . '" ' . $selected . '>' . $role['role'] . '</option>';
                                    } 
                            ?>
                        </select>
                    </div>
                </fieldset>
                <button type="submit" id="addUserButton" class="btn btn-primary">Ajouter</button>
            </form>
        <div class="container-fluid col-12 col-md-10 adm">

        <h2>Les utilisateurs actuels</h2>
        <div class="table-responsive">
            <table id="list-user"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <th><i id="sort-icon-id" class="bi bi-sort-down"></i> id </th>
                        <th><i id="sort-icon-name" class="bi bi-sort-down"></i> Nom </th>
                        <th><i id="sort-icon-forname" class="bi bi-sort-down"></i> Prénom </th>
                        <th><i id="sort-icon-email" class="bi bi-sort-down"></i> Email </th>
                        <th><i id="sort-icon-role" class="bi bi-sort-down"></i> Role </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php

                    foreach ($users as $user) {
                        echo '<tr data-id="' . $user['id'] . '">';
                        echo '<td>' . $user['id'] . '</td>';
                        echo '<td>' . $user['name'] . '</td>';
                        echo '<td>' . $user['forename']. '</td>';
                        echo '<td>' . $user['email']. '</td>';
                        
                        echo '<td>';
                        echo '<select class="form-select" name="role">';
                        foreach ($roles as $role) {
                            $selected = ($role['role'] == $user['role']) ? 'selected' : '';
                            echo '<option value="' . $role['id'] . '" ' . $selected . '>' . $role['role'] . '</option>';
                        }
                        echo '</select>';
                        echo '</td>';

                        echo '<td class="icon-cell">' .
                            '<i class="bi bi-trash" data-id="' . $user['id'] . '"></i>'.
                            '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table> 
        </div>
    </div>