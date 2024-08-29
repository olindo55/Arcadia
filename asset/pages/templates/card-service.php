<?php
$query = DbConnection::getPdo()->query('SELECT * FROM service');
$services = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($services as $service) { ?>
          <div class="swiper-slide">
          <div class="card-service">
            <img src=<?php echo $service['image_url'] ?> alt=<?php echo $service['image_alt'] ?>>
            <h4><?php echo $service['name'] ?></h4>
          </div>
        </div>
<?php } ?>
 