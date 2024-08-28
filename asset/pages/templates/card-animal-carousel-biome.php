<?php foreach ($animals as $animal) { ?>
    <div class="swiper-slide">
        <div class="carrousel-animal-card">
            <img src=<?php echo $animal['image_url'] ?> alt=<?php echo $animal['image_alt'] ?>>
            <div class="report">
                <h2><?php echo $animal['name'] ?></h2>
                <ul>
                    <li><p>Race: 
                        <?php
                                    $queryBreed = $pdo->prepare('SELECT name FROM breed WHERE id = :animal_breed_id LIMIT 1;');
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
                                    $queryBiome = $pdo->prepare('SELECT name FROM biome WHERE id = :animal_biome_id');
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
                                    $queryFood = $pdo->prepare('SELECT * FROM feeding WHERE animal_id = :animal_id LIMIT 1');
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
                        $queryScore = $pdo->prepare('SELECT * FROM vet_report WHERE animal_id = :animal_id LIMIT 1');
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
                </ul>
            </div>
        </div>
    </div>
<?php } ?>