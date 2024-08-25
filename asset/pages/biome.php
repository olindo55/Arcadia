<div id="accordion-biome">
    <!-- php ou pas pour item biome? -->
    <div class="accordion-biome-item">
        <div class="accordion-biome-card">
            <picture>
                <source media="(min-width: 768px)" srcset="/asset/images/biome/high-resolution/marie-helene-rots-aBepZL2ASGw-unsplash.jpg">
                <img src="/asset/images/biome/marie-helene-rots-aBepZL2ASGw-unsplash.jpg" alt="paysage de marais">
            </picture>
            <div class="title-biome-card">
                <h1>Marais</h1>
                <p>Bienvenue dans l'univers fascinant des marais, ces écosystèmes mystérieux et riches en vie, où l'eau douce rencontre la terre. Les marais sont des lieux de biodiversité exceptionnelle, abritant une multitude d'espèces animales et végétales qui coexistent dans une harmonie délicate.</p>
            </div>
        </div>
        <!-- accordion of animals max-width 767px-->
        <div class="accordion accordion-flush" id="accordionFlush">
            <!-- cards animal -->
            <?php include 'templates/card-animal-accordion-biome.php';?>
        </div>
        <!-- carrousel of animals min-width 768px-->
        <div class="swiper swiperAnimal">
            <div class="swiper-wrapper">
                <!-- Cards animal -->
                <?php include 'templates/card-animal-carousel-biome.php';?>
                <?php include 'templates/card-animal-carousel-biome.php';?>
                <?php include 'templates/card-animal-carousel-biome.php';?>
                <?php include 'templates/card-animal-carousel-biome.php';?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div> 
    </div>
</div>