<?php 
use App\Database\DbUtils;
?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des avis</h1>
        <table id="list-comment"  class="table table-hover table-responsive">
            <thead>
                <tr class="table-primary ">
                    <th><i id="sort-icon-id" class="bi bi-sort-alpha-down"></i> id </th>
                    <th><i id="sort-icon-published" class="bi bi-sort-alpha-down"></i> Publié </th>
                    <th><i id="sort-icon-pseudo" class="bi bi-sort-alpha-down"></i> Pseudo </th>
                    <th>Avis</th>
                    <th><i id="sort-icon-score" class="bi bi-sort-alpha-down"></i> Score </th>
                    <th><i id="sort-icon-date" class="bi bi-sort-alpha-down"></i> Date de l'avis </th>
                    <th><i id="sort-icon-approver" class="bi bi-sort-alpha-down"></i> Validateur </th>
                    <th></th>
                </tr>
            </thead>
            <tbody >
                <!--injection via php--> 
                <?php
                $query = DbUtils::getPdo()->query('
                    SELECT c.id, c.pseudo, c.comment, c.date_comment, c.score, 
                    c.published, u.name, u.forename 
                    FROM comment c 
                    LEFT JOIN users u ON c.user_id = u.id'
                );
                $comments = $query->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($comments as $comment) {
                    echo '<tr data-id="' . $comment['id'] . '">';
                    echo '<td>' . $comment['id'] . '</td>';

                    echo '<td>';
                    echo '<div class="form-check form-switch">';
                    echo '<input class="form-check-input" type="checkbox" ' . ($comment['published'] ? 'checked' : '') . '>';
                    echo '</div>';
                    echo '</td>';

                    echo '<td>' . $comment['pseudo'] . '</td>';
                    echo '<td>' . $comment['comment']. '</td>';
                    echo '<td>' . $comment['score'] . '/5</td>';
                    echo '<td>' . $comment['date_comment'] . '</td>';
                    echo '<td>' . $comment['name'] . ' ' . $comment['forename'] . '</td>';

                    echo '<td class="icon-cell">' .
                        '<i class="bi bi-trash" data-id="' . $comment['id'] . '"></i>'.
                        '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table> 
    </div>