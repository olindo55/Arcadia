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
    LEFT JOIN latest_feeding lf ON lf.animal_id = a.id
    LEFT JOIN users s ON s.id = lf.user_id
    JOIN biome bi ON bi.id = a.biome_id
    LEFT JOIN latest_biome_report lbr ON lbr.biome_id = a.biome_id
    ORDER BY vr.date_report DESC;
    ');
$vet_reports = $query->fetchAll(\PDO::FETCH_ASSOC);

$query = DbUtils::getPdo()->query('
    SELECT 
        a.id AS animal_id, a.name AS animal_name,
        b.id AS biome_id, b.name AS biome_name
    FROM animal a
    JOIN biome b ON b.id = a.biome_id
    ');
$animals = $query->fetchAll(\PDO::FETCH_ASSOC);

$id = isset($_SESSION['selected_id']) ? $_SESSION['selected_id'] : 0;
unset($_SESSION['selected_id']);

// echo '<pre>'; // Formate l'affichage
// var_dump($vet_reports);
// echo '</pre>';

// echo $_SESSION['user_id']
?>

    <!-- title -->
    <h1>Rapports vétérinaires</h1>
    <div class="contents">
        <!-- reporting -->
        <div class="report container-fluid col-12 col-md-6">   
            <div class="search">
                    <!-- add button -->
                <?php if ($_SESSION['role'] == 'vétérinaire') { ?>
                    <div class="myButtonAdd container-fluid">
                        <i class="bi bi-clipboard-plus"></i>
                    </div>
                <?php } ?>
                <!-- search -->
                <div class="searchBy container-fluid col-12 col-md-6">
                    <label for="searchByAnimal" class="form-label">Animal</label>
                    <input type="search" class="form-control mb-3" id="searchByAnimal" placeholder="Rechercher par animal...">
            
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
                            $i = -1;
                            foreach ($vet_reports as $vet_report) {
                                $i++;
                                echo '<tr data-id="' . $vet_report['id'] . '">';
                                echo '<td class="animal-name">' . $vet_report['animal_name'] . '</td>';
                                echo '<td class="date-report">' . $vet_report['date_report'] . '</td>';
                                echo '<td class="icon-cell">' 
                                    . '<i class="bi bi-eye" data-id="' . $i . '"></i>'
                                    .'</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Report List -->
        <div class="container-fluid col-11 col-md-6 col-xl-4 vet-report">
            <div class="animal">
                <div class="bloc-img-animal position-relative">
                    <img src=<?php echo  $vet_reports[$id]['img']?> alt=<?php echo  $vet_reports[$id]['alt']?>  class="img-animal">
                    <h4><span class="translate-middle badge rounded-pill bg-danger position-absolute top-0 start-100">
                        103
                    </span></h4>
                </div>
                <h2><?php echo  $vet_reports[$id]['animal_name']?></h2>
                <p>Race : <?php echo  $vet_reports[$id]['breed']?></p>
                <p>Etat de santé : 
                    <span class="hearts">
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $vet_reports[$id]['score']) {
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
                <p class="first"><strong>Vétérinaire : </strong>Dr <?php echo  $vet_reports[$id]['vet_name']?> <?php echo  $vet_reports[$id]['vet_forename']?></p>
                <p><strong>Date de visite : </strong> <?php echo  $vet_reports[$id]['date_report']?></p>
                <p><strong>Commentaire général : </strong> <?php echo  $vet_reports[$id]['comment']?> </p>
            </div>
            <div class="group">
                <h3>Nourriture</h3>
                <p class="first"><strong>Date : </strong> <?php echo  $vet_reports[$id]['date_food']?></p>
                <p><strong>Type : </strong><?php echo  $vet_reports[$id]['food']?></p>
                <p><strong>Quantité en gr : </strong><?php echo  $vet_reports[$id]['quantity']?>gr</p>
                <p><strong>Soigneur : </strong> <?php echo  $vet_reports[$id]['emp_forename']?> <?php echo  $vet_reports[$id]['emp_name']?> </p>
            </div>
            <div class="group">
                <h3>Habitat</h3>
                <p class="first"><strong>Type : </strong><?php echo  $vet_reports[$id]['biome_name']?></p>
                <p><strong>Commentaire : </strong><?php echo  $vet_reports[$id]['biome_comment']?></p>
                <p class="stars"><strong>Etat : </strong> 
                    <span>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $vet_reports[$id]['biome_score']) {
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

    <?php if ($_SESSION['role'] == 'vétérinaire') { ?>
        <!-- Modal add report -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau Rapport</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="container-fluid" id="modal-form">
                        <form method="post" action="" id="admForm" class="container-fluid col-12" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="animal" class="form-label">Animal</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select" id="animal-select" name="animal_id">
                                        <?php foreach ($animals as $animal) {
                                                echo '<option value="' . $animal['animal_id'] . '" data-bio="' . $animal['biome_name'] . '">' . $animal['animal_name'] . '</option>';
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new-report-animal" class="form-label">Commentaires</label>
                                <textarea class="form-control" id="new-report-animal" name="new-report-animal" rows="4" placeholder="Écrivez votre texte ici..." required>
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label for="health-score" class="form-label">Note sur 5</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select" name="health-score">
                                        <?php for($j = 1; $j <=5; $j++) {
                                                echo '<option value="' . $j . '">' . $j . '</option>';
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <h5 id="biome-by-animal">Sélectionnez un animal pour voir son habitat</h5>
                            <div class="mb-3">
                                <label for="new-report-biome" class="form-label">Commentaires</label>
                                <textarea class="form-control" id="new-report-biome" name="new-report-biome" rows="4" cols="50" placeholder="Écrivez votre texte ici..." required>
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label for="biome-score" class="form-label">Note sur 5</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-select" name="biome-score">
                                        <?php for($j = 1; $j <=5; $j++) {
                                                echo '<option value="' . $j . '">' . $j . '</option>';
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" id="addReportButton" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
            </div>
        </div>
    <?php } ?>
</div>