<?php 
// require_once 'app/config/config.php';
use App\Database\DbUtils;
?>

<section class="service-hero">
    <h1>Nos services<span class="point">.</span></h1>
    <p>Bienvenue au Zoo Arcadia, un lieu dédié à la découverte et à la protection de la faune sauvage. Situé au cœur d’un environnement naturel exceptionnel, la forêt de Brocéliande,  notre zoo offre une multitude de services conçus pour rendre votre visite non seulement agréable, mais aussi éducative et inspirante. Que vous soyez un passionné de la nature, un amateur d'animaux ou une famille en quête d'aventures, nos services sont pensés pour répondre à vos besoins et surpasser vos attentes.</p>
</section>
<section class="all-services">
    <?php
    $query = DbUtils::getPdo()->query('SELECT * FROM service');
    $services = $query->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    foreach ($services as $service) { ?>
    <article class=<?php echo ($i % 2 === 0) ? "left-card" : "right-card"; ?>>
            <div class="text-services">
                <h2><?php echo $service['name'] ?></h2>
                <p><?php echo $service['description'] ?></p>
            </div>
            <figure>
                <img src=<?php echo $service['image_url'] ?> alt=<?php echo $service['image_alt'] ?>>
            </figure>
    </article>
    <?php $i++; 
    } ?>
