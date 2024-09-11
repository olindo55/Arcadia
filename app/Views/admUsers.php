<?php 
use App\Database\DbUtils;
?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des utilisateurs</h1>
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