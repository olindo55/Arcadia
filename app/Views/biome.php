<?php require_once 'app/config/config.php';
use App\Database\DbUtils;
?>

<?php
$queryBiomes = DbUtils::getPdo()->query('SELECT * FROM biome');
$biomes = $queryBiomes->fetchAll(PDO::FETCH_ASSOC);
?>


<div id="accordion-biome">
<?php foreach ($biomes as $biome) { ?>
    <div class="accordion-biome-item">
        <div class="accordion-biome-card">
            <picture>
                <source media="(min-width: 768px)" srcset=<?php echo $biome['image_url_hd'] ?>>
                <img src=<?php echo $biome['image_url'] ?> alt=<?php echo $biome['image_alt'] ?>>
            </picture>
            <div class="title-biome-card">
                <h1><?php echo $biome['name'] ?></h1>
                <p><?php echo $biome['description'] ?></p>
            </div>
        </div>
        <!-- accordion of animals max-width 767px-->
        <div class="accordion accordion-flush" id="accordionFlush">
            <!-- cards animal -->
            <?php 
                $queryAnimals = DbUtils::getPdo()->prepare('SELECT * FROM animal WHERE biome_id = (SELECT id FROM biome WHERE name = :biome_name)');
                $queryAnimals->bindParam(':biome_name', $biome['name']);
                $queryAnimals->execute();
                $animals = $queryAnimals->fetchAll(PDO::FETCH_ASSOC);
                include 'templates/card-animal-accordion-biome.php';
            ?>
        </div>
        <!-- carrousel of animals min-width 768px-->
        <div class="swiper swiperAnimal">
            <div class="swiper-wrapper">
                <!-- Cards animal -->
                <?php 
                    include 'templates/card-animal-carousel-biome.php';
                ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div> 
    </div>
</div>
<?php } ?>