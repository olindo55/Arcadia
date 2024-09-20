<?php 
use App\Database\DbUtils;
$query = DbUtils::getPdo()->query('
    WITH latest_feeding AS (
        SELECT f1.animal_id, f1.date_feeding, f1.type_food, f1.quantity,f1.user_id
        FROM feeding f1
        JOIN (
            SELECT animal_id, MAX(date_feeding) AS latest_date
            FROM feeding GROUP BY animal_id) f2 ON f1.animal_id = f2.animal_id AND f1.date_feeding = f2.latest_date
    )    ,
    latest_biome_report AS (
        SELECT br1.id, br1.date_report, br1.comment, br1.score, br1.user_id, br1.biome_id
        FROM biome_report br1
        JOIN (
            SELECT biome_id, MAX(date_report) AS latest_date_report
            FROM biome_report GROUP BY biome_id) br2 ON br1.biome_id = br2.biome_id AND br1.date_report = br2.latest_date_report
    )
    SELECT 
        vr.id, vr.date_report, vr.comment, vr.score, 
        a.name AS animal_name, a.image_url AS img, a.image_alt AS alt, a.biome_id AS biome,
        v.name AS vet_name, v.forename AS vet_forename, 
        b.name AS breed,
        lf.date_feeding AS date_food, lf.type_food AS food, lf.quantity AS quantity, lf.user_id AS employee,
        s.name AS emp_name, s.forename AS emp_forename,
        bi.name AS biome_name,
        lbr.comment AS biome_comment, lbr.score AS biome_score
    FROM vet_report vr
    JOIN animal a ON a.id = vr.animal_id
    JOIN breed b ON  b.id = a.breed_id
    JOIN users v ON v.id = vr.user_id 
    JOIN latest_feeding lf ON lf.animal_id = a.id
    JOIN users s ON s.id = lf.user_id
    JOIN biome bi ON bi.id = a.biome_id
    JOIN latest_biome_report lbr ON lbr.biome_id = a.biome_id
    ORDER BY vr.date_report DESC;
    ');

 
    

$vet_reports = $query->fetchAll(\PDO::FETCH_ASSOC);
?>
    <!-- title -->
    <h1>Gestion des rapports vétérinaires</h1>
    <div class="contents">
        <!-- reporting -->
        <div class="report container-fluid col-12 col-md-6">   
            <div class="search">
                    <!-- add button -->
                <div class="myButtonAdd container-fluid">
                    <i class="bi bi-clipboard-plus"></i>
                </div>
                <!-- search -->
                <div class="searchBy container-fluid col-12 col-md-6">
                    <label for="searchByAnimal" class="form-label">Animal</label>
                    <input type="text" class="form-control mb-3" id="searchByAnimal" placeholder="Rechercher par animal...">
            
                    <label for="searchByDate" class="form-label">Date de rapport</label>
                    <input type="date" class="form-control mb-3" id="searchByDate" >
                </div>
                <!--  list  -->
                <div class="table-responsive">
                    <table id="list-vet"  class="table table-hover table-responsive mt-3">
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
                            foreach ($vet_reports as $vet_report) {
                                
                                echo '<tr data-id="' . $vet_report['id'] . '">';
                                echo '<td class="animal-name">' . $vet_report['animal_name'] . '</td>';
                                echo '<td class="date-report">' . $vet_report['date_report'] . '</td>';
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
        </div>
        <!-- Report -->
        <div class="container-fluid col-11 col-md-6 col-xl-4 vet-report">
            <div class="animal">
                <div class="bloc-img-animal position-relative">
                    <img src=<?php echo  $vet_reports[0]['img']?> alt=<?php echo  $vet_reports[0]['alt']?>  class="img-animal">
                    <h4><span class="translate-middle badge rounded-pill bg-danger position-absolute top-0 start-100">
                        103
                    </span></h4>
                </div>
                <h2><?php echo  $vet_reports[0]['animal_name']?></h2>
                <p>Race : <?php echo  $vet_reports[0]['breed']?></p>
                <p>Etat de santé : 
                    <span class="hearts">
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $vet_reports[0]['score']) {
                                echo '<i class="bi bi-heart-fill"></i>';
                            } else {
                                echo '<i class="bi bi-heart"></i>';
                            }
                        }                            
                        ?>
                    </span></p>
            </div>
            <div class="group">
                <h3>Vétérinaire</h3>
                <p class="first"><strong>Vétérinaire : </strong>Dr <?php echo  $vet_reports[0]['vet_name']?> <?php echo  $vet_reports[0]['vet_forename']?></p>
                <p><strong>Date de visite : </strong> <?php echo  $vet_reports[0]['date_report']?></p>
                <p><strong>Commentaire général : </strong> <?php echo  $vet_reports[0]['comment']?> </p>
            </div>
            <div class="group">
                <h3>Nourriture</h3>
                <p class="first"><strong>Date : </strong> <?php echo  $vet_reports[0]['date_food']?></p>
                <p><strong>Type : </strong><?php echo  $vet_reports[0]['food']?></p>
                <p><strong>Quantité en gr : </strong><?php echo  $vet_reports[0]['quantity']?>gr</p>
                <p><strong>Soigneur : </strong> <?php echo  $vet_reports[0]['emp_forename']?> <?php echo  $vet_reports[0]['emp_name']?> </p>
            </div>
            <div class="group">
                <h3>Habitat</h3>
                <p class="first"><strong>Type : </strong><?php echo  $vet_reports[0]['biome_name']?></p>
                <p><strong>Commentaire : </strong><?php echo  $vet_reports[0]['biome_comment']?></p>
                <p class="stars"><strong>Etat : </strong> 
                    <span>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $vet_reports[0]['biome_score']) {
                                echo '<span class="star selected">★</span>';
                            } else {
                                echo '<span class="star">★</span>';
                            }
                        }                            
                        ?>
                    </span>
                </p>
            </div>
        </div>
    </div>