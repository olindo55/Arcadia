<?php 
use App\Database\DbUtils;

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
                            $query = DbUtils::getPdo()->query('
                                SELECT vet_report.id, vet_report.date_report, animal.name 
                                FROM vet_report
                                JOIN animal ON vet_report.animal_id = animal.id
                            ');

                            $vet_reports = $query->fetchAll(\PDO::FETCH_ASSOC);

                            foreach ($vet_reports as $vet_report) {
                                
                                echo '<tr data-id="' . $vet_report['id'] . '">';
                                echo '<td class="animal-name">' . $vet_report['name'] . '</td>';
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
                    <img src="/asset/images/animals/jungle/angel-luciano-zTGzwYKXC-A-unsplash.jpg" alt=""  class="img-animal">
                    <h4><span class="translate-middle badge rounded-pill bg-danger position-absolute top-0 start-100">
                        103
                    </span></h4>
                </div>
                <h2>Turing</h2>
                <p>Race : gorille</p>
                <p>Etat de santé : 
                    <span class="hearts">
                        <?php                            
                        for ($i = 0; $i < 5; $i++){ ?>
                        <i class="bi bi-heart-fill"></i>
                        <?php } ?>
                    </span></p>
            </div>
            <div class="group">
                <h3>Vétérinaire</h3>
                <p class="first"><strong>Vétérinaire : </strong> Dr Lopez</p>
                <p><strong>Date de visite : </strong> 04/08/2024</p>
                <p><strong>Commentaire général : </strong> Turin se remet doucement des soins du à sa blessure à l’oreille gauche. </p>
            </div>
            <div class="group">
                <h3>Nourriture</h3>
                <p class="first"><strong>Date : </strong> 04/08/2024</p>
                <p><strong>Type : </strong> Banane</p>
                <p><strong>Quantité en gr : </strong> 2000gr </p>
                <p><strong>Soigneur : </strong> Jean Michemuche </p>
            </div>
            <div class="group">
                <h3>Habitat</h3>
                <p class="first"><strong>Type : </strong> Jungle</p>
                <p><strong>Commentaire : </strong>L’enclos des chimpanzés manque de jeux naturels, il faudrait prévoir une balancoire pneu...</p>
                <p class="stars"><strong>Etat : </strong> 
                    <span>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                                echo '<span class="star selected">★</span>';
                        }
                        ?>
                    </span>
                </p>
            </div>
        </div>
    </div>