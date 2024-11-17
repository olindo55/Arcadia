<?php 
   use App\Database\DbUtils;

    $i=0;    
    foreach ($animals as $animal) { 
            $i++ ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading<?php echo $i.'_'.$animal['id'] ?>"> <!-- attention nbre --> 
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $i.'_'.$animal['id'] ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $i.'_'.$animal['id'] ?>"> <!-- attention nbres --> 
                        <?php echo $animal['name'] ?>
                    </button>
                </h2>
                <div id="flush-collapse<?php echo $i.'_'.$animal['id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $i.'_'.$animal['id'] ?>" data-bs-parent="#accordionFlushExample"> <!-- attention nbres --> 
                    <div class="accordion-body">
                        <img src=<?php echo $animal['image_url'] ?> alt=<?php echo $animal['image_alt'] ?>>
                        <ul>
                            <li><p>Race: 
                                <?php
                                    $queryBreed = DbUtils::getPdo()->prepare('SELECT name FROM breed WHERE id = :animal_breed_id LIMIT 1;');
                                    $queryBreed->bindParam(':animal_breed_id', $animal['breed_id']);
                                    $queryBreed->execute();
                                    $breed = $queryBreed->fetch(PDO::FETCH_ASSOC);
                                    
                                    if ($breed) {
                                        echo $breed['name'];
                                    } else {
                                        echo 'Breed not found.';
                                    }
                                ?>
                            </p></li>
                            <li><p>Habitats :  
                                <?php
                                    $queryBiome = DbUtils::getPdo()->prepare('SELECT name FROM biome WHERE id = :animal_biome_id');
                                    $queryBiome->bindParam(':animal_biome_id', $animal['biome_id']);
                                    $queryBiome->execute();
                                    $biome = $queryBiome->fetch(PDO::FETCH_ASSOC);
                                    
                                    if ($breed) {
                                        echo $biome['name'];
                                    } else {
                                        echo 'Biome not found.';
                                    }
                                ?>
                            </p></li>

                            <!-- according with feeding -->
                            <?php
                                    $queryFood = DbUtils::getPdo()->prepare('SELECT * FROM feeding WHERE animal_id = :animal_id ORDER BY id DESC LIMIT 1');
                                    $queryFood->bindParam(':animal_id', $animal['id']);
                                    $queryFood->execute();
                                    $food = $queryFood->fetch(PDO::FETCH_ASSOC);

                                    if ($food) {
                            ?>
                            <li><p>Pour son repas, nos soigneurs lui ont servi, <?php echo $food['quantity']; ?> grammes de <?php echo $food['type_food']; ?></p></li>
                            <?php } else {?>
                            <p>Pas de rapport de nourriture disponible.</p>
                            <?php }?>

                            <!-- according with vet_report -->
                            <?php 
                                $queryScore = DbUtils::getPdo()->prepare('SELECT * FROM vet_report WHERE animal_id = :animal_id ORDER BY id DESC LIMIT 1');
                                $queryScore->bindParam(':animal_id', $animal['id']);
                                $queryScore->execute();
                                $vet_report = $queryScore->fetch(PDO::FETCH_ASSOC);
                                if ($vet_report) {
                            ?>
                                    <li><p>Notre vétérinaire l’a examiné, pour la dernière fois le <?php echo $vet_report['date_report']?></p></li>
                                    <li><p>Etat de santé : </p></li>
                                    <li class="hearts">
                                    <?php                            
                                    for ($i = 0; $i < $vet_report['score']; $i++){ ?>
                                    <i class="bi bi-heart-fill"></i>
                                    <?php } ?>
                                    <?php for ($i = $vet_report['score']; $i < 5; $i++){ ?>
                                    <i class="bi bi-heart"></i>
                                    <?php } ?>
                            <?php } else { ?>
                                <p>Pas de rapport vétérinaire disponible.</p>
                            <?php } ?>
                            </li>
                            <li class="like">
                                <i class="bi bi-hand-thumbs-up-fill"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
<?php } ?>
