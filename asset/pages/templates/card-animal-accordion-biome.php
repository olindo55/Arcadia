<!-- implementer une boucle selon data base --> 
<?php 
    $i=0;    
    foreach ($animals as $animal) { 
            $i++ ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading<?php echo $i.'_'.$biome['id'] ?>"> <!-- attention nbre --> 
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $i.'_'.$biome['id'] ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $i.'_'.$biome['id'] ?>"> <!-- attention nbres --> 
                        <?php echo $animal['name'] ?>
                    </button>
                </h2>
                <div id="flush-collapse<?php echo $i.'_'.$biome['id'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $i.'_'.$biome['id'] ?>" data-bs-parent="#accordionFlushExample"> <!-- attention nbres --> 
                    <div class="accordion-body">
                        <img src=<?php echo $animal['image_url'] ?> alt=<?php echo $animal['image_alt'] ?>>
                        <ul>
                            <li><p>Race: <?php echo $animal['breed'] ?></p></li>
                            <li><p>Habitats : <?php echo $biome['name'] ?></p></li>
                            <li><p>Pour son repas, nos soigneurs lui ont servi, <?php echo $animal['feeding_quantity'] ?> grammes de viande de <?php echo $animal['feeding_type'] ?></p></li>
                            <li><p>Notre vétérinaire l’a visité ce matin.</p></li>
                            <li><p>Etat de santé : </p></li>
                            <li class="hearts">
                                <i class="bi bi-heart-fill"></i>
                                <i class="bi bi-heart-fill"></i>
                                <i class="bi bi-heart-fill"></i>
                                <i class="bi bi-heart-fill"></i>
                                <i class="bi bi-heart"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
<?php } ?>
