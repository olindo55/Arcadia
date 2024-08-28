<?php include_once 'connection/pdo.php'; ?>
<section class="service-hero">
    <h1>Nos services<span class="point">.</span></h1>
    <p>Bienvenue au Zoo Arcadia, un lieu dédié à la découverte et à la protection de la faune sauvage. Situé au cœur d’un environnement naturel exceptionnel, la forêt de Brocéliande,  notre zoo offre une multitude de services conçus pour rendre votre visite non seulement agréable, mais aussi éducative et inspirante. Que vous soyez un passionné de la nature, un amateur d'animaux ou une famille en quête d'aventures, nos services sont pensés pour répondre à vos besoins et surpasser vos attentes.</p>
</section>
<section class="all-services">
    <?php
    $query = $pdo->query('SELECT * FROM service');
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


<!-- 
    <article class="left-card">
        <div class="text-services">
            <h2>Visites guidées</h2>
            <p>Découvrez le zoo comme jamais auparavant grâce à nos visites guidées! Accompagné par un guide passionné, explorez les différentes espèces animales et apprenez des anecdotes fascinantes sur leur habitat et leur comportement. Que vous soyez curieux ou expert, cette visite enrichissante vous plongera dans le monde des animaux tout en répondant à vos questions. Idéale pour les familles et les groupes, elle vous offre une occasion unique de voir de plus près la vie sauvage et de comprendre les enjeux de la conservation. Une expérience éducative et immersive à ne pas manquer!</p>
        </div>
        <figure>
            <img src="../../asset/images/services/visites_guidees.jpg" alt="Un guide explique le zoo aux visiteurs">
        </figure>
    </article>
    <article class="right-card">
        <div class="text-services">
            <h2>Restauration</h2>
            <p>Après une journée d’exploration, faites une pause gourmande dans notre restaurant. Nous proposons une cuisine variée, élaborée à partir de produits frais, pour satisfaire tous les appétits. Que vous souhaitiez un repas complet ou simplement une collation, notre menu s’adapte à vos envies. Profitez de notre terrasse en plein air pour savourer votre repas dans un cadre naturel et apaisant. Notre restaurant est également équipé pour accueillir les familles avec des options pour enfants. Reposez-vous et rechargez vos batteries avant de continuer votre aventure au zoo.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/kristof-korody-udN5SKlmtqg-unsplash.jpg" alt="Une assiette d'un plat servis dans notre restaurant">
        </figure>
    </article>
    <article class="left-card">
        <div class="text-services">
            <h2>Petit train</h2>
            <p>Embarquez à bord de notre petit train pour une visite relaxante du zoo! Ce moyen de transport ludique est idéal pour découvrir les différents espaces du parc sans effort. Le trajet vous emmène à travers nos habitats thématiques, vous offrant une vue d’ensemble sur les animaux et leur environnement. Le petit train est accessible à tous, y compris aux familles avec enfants et aux personnes à mobilité réduite. Une façon confortable et amusante de parcourir le zoo, tout en profitant de commentaires audio pour enrichir votre visite. Laissez-vous guider.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/casey-horner-p69o_a7XqDM-unsplash.jpg" alt="Le petit train sort du biome Jungle">
        </figure>
    </article>
    <article class="right-card">
        <div class="text-services">
            <h2>Nourrissage</h2>
            <p>Vivez un moment privilégié en assistant au nourrissage des animaux! Nos soigneurs vous invitent à découvrir les coulisses du zoo en vous montrant comment ils prennent soin de nos pensionnaires. Vous pourrez observer de près le comportement des animaux durant ce moment crucial de la journée et en apprendre davantage sur leur régime alimentaire. C’est l’occasion parfaite pour poser toutes vos questions et mieux comprendre les besoins spécifiques de chaque espèce. Une activité captivante qui ravira petits et grands, tout en sensibilisant à la conservation et au bien-être animal.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/daiga-ellaby-p-vf1RhLzsc-unsplash.jpg" alt="Un soigneur nourrissant les animaux">
        </figure>
    </article>
    <article class="left-card">
        <div class="text-services">
            <h2>Spectacles</h2>
            <p>Laissez-vous émerveiller par nos spectacles animaliers, où la nature devient spectacle! Nos spectacles sont conçus pour éduquer tout en divertissant, mettant en scène des animaux fascinants qui dévoilent leurs talents naturels. Chaque représentation est unique, mettant en lumière les comportements instinctifs et les capacités extraordinaires de nos animaux vedettes. Que ce soit un spectacle de perroquets colorés ou un show avec nos animaux sauvages, vous en sortirez avec des souvenirs inoubliables. Une expérience à ne pas manquer pour toute la famille, mêlant pédagogie et émerveillement.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/ankush-minda-Bsxv_Nbs-VY-unsplash.jpg" alt="Un spectacle de perroquet">
        </figure>
    </article>
    <article class="right-card">
        <div class="text-services">
            <h2>Ateliers éducatifs</h2>
            <p>Encouragez la curiosité et la créativité de vos enfants avec nos ateliers éducatifs! Conçus pour les plus jeunes, ces ateliers interactifs leur permettent de découvrir le monde des animaux de manière ludique. Accompagnés de nos animateurs, les enfants participent à des activités manuelles, des jeux éducatifs et des expériences sensorielles qui éveillent leur intérêt pour la nature et la biodiversité. Chaque atelier est une aventure unique, adaptée à l'âge et au rythme des participants. Offrez-leur une expérience d'apprentissage amusante et enrichissante qui complétera leur visite au zoo.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/atelier-enfants.jpg" alt="Atelier éducatif pour les enfants">
        </figure>
    </article>
    <article class="left-card">
        <div class="text-services">
            <h2>Expositions</h2>
            <p>Plongez au cœur de la biodiversité avec nos expositions thématiques! Ces espaces dédiés vous invitent à découvrir des espèces rares et fascinantes, des insectes aux reptiles, en passant par des plantes exotiques. Chaque exposition est soigneusement conçue pour offrir un aperçu approfondi de l’écosystème représenté, avec des informations claires et accessibles. Vous aurez l’occasion d’explorer des environnements recréés avec soin, où chaque détail compte. Que vous soyez passionné de biologie ou simple curieux, nos expositions enrichissent votre visite en vous offrant une immersion totale dans le monde naturel.</p>
        </div>
        <figure>
            <img src="../../asset/images/services/butterfly-biodiversity-two-column.jpg.thumb.768.768.jpg" alt="Différent papillons">
        </figure>
    </article> -->
</section>