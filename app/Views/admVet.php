<?php 
use App\Database\DbUtils;

?>

    <div class="container-fluid col-12 col-md-10 adm">
        <h1>Gestion des rapports vétérinaires</h1>

        <!-- <input type="text" id="search" placeholder="Recherche..."> -->
        <div class="table-responsive">
            <table id="list-vet"  class="table table-hover table-responsive">
                <thead>
                    <tr class="table-primary ">
                        <!-- <th id="sort-name"><i id="sort-icon-name" class="bi bi-sort-down"></i>Name</th>  -->
                        <th><i id="sort-icon-name" class="bi bi-sort-down"></i>Animal</th> 
                        <th><i id="sort-icon-date" class="bi bi-sort-down"></i>Date du rapport</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody >
                    <!--injection via php--> 
                    <?php
                    $query = DbUtils::getPdo()->query('
                        SELECT vet_report.id, vet_report.date_report, animal.name 
                        FROM vet_report
                        JOIN animal ON vet_report.animal_id = animal.id
                    ');

                    $vet_reports = $query->fetchAll(\PDO::FETCH_ASSOC);

                    foreach ($vet_reports as $vet_report) {
                        
                        echo '<tr data-id="' . $vet_report['id'] . '">';
                        echo '<td>' . $vet_report['name'] . '</td>';
                        echo '<td>' . $vet_report['date_report'] . '</td>';
                        echo '<td class="icon-cell">' 
                            . '<i class="bi bi-eye" data-id="' . $vet_report['id'] . '"></i>'
                            . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>