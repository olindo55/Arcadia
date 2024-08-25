<?php foreach ($animals as $animal) { ?>
    <div class="swiper-slide">
        <div class="carrousel-animal-card">
            <img src=<?php echo $animal['image_url'] ?> alt=<?php echo $animal['image_alt'] ?>>
            <div class="report">
                <h2><?php echo $animal['name'] ?></h2>
                <ul>
                    <li><p>Race: <?php echo $animal['breed'] ?></p></li>
                    <li><p>Habitats : <?php echo $biome['name'] ?></p></li>
                    <li><p>Pour son repas, nos soigneurs lui ont servi, <?php echo $animal['feeding_quantity'] ?> grammes de <?php echo $animal['feeding_type'] ?></p></li>
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