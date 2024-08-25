<?php
$query = $pdo->query('SELECT * FROM biomes');
$biomes = $query->fetchAll(PDO::FETCH_ASSOC);
$threeFirstBiomes = array_slice($biomes, 0, 3);
?>

<?php foreach ($threeFirstBiomes as $biome) { ?>
    <a href="/biome">
        <div class="card-biome">
            <img src=<?php echo $biome['image_url'] ?> class="rounded w-100" alt=<?php echo $biome['image_alt'] ?>/>
            <h3><?php echo $biome['name'] ?></h3>
            <p><?php echo $biome['description'] ?></p>
        </div>
    </a>
<?php } ?>

<!-- implementer la boucle selon data base, 3 biomes seulement-->
    <!-- <div class="card-biome">
        <img src="/asset/images/biome/marie-helene-rots-aBepZL2ASGw-unsplash.jpg" class="rounded w-100" alt="paysage de marais"/>
        <h3>Marais</h3>
        <p>Bienvenue dans l'univers fascinant des marais, ces écosystèmes mystérieux et riches en vie, où l'eau douce rencontre la terre. Les marais sont des lieux de biodiversité exceptionnelle, abritant une multitude d'espèces animales et végétales qui coexistent dans une harmonie délicate.</p>
    </div>
    <div class="card-biome">
        <img src="/asset/images/biome/daphne-fecheyr-N7uZUNwcrog-unsplash.jpg" class="rounded w-100" alt="paysage de marais"/>
        <h3>Savane</h3>
        <p>La savane est un écosystème unique, caractérisé par ses saisons sèches et humides, et abritant une diversité impressionnante de faune. Ici, la vie sauvage s'organise autour des points d'eau vitaux, et chaque animal joue un rôle crucial dans l'équilibre de cet environnement.</p>
      </div>
      <div class="card-biome">
        <img src="/asset/images/biome/chris-abney-qLW70Aoo8BE-unsplash.jpg" class="rounded w-100" alt="paysage de marais"/>
        <h3>Jungle</h3>
        <p>La jungle est un écosystème complexe et dynamique où cohabitent une multitude d'animaux, des plus petits insectes aux majestueux félins. C'est un lieu de biodiversité sans égal, offrant un refuge à des espèces uniques et souvent menacées.</p>
    </div> -->