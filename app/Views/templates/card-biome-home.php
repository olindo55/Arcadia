<?php
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM biome');
$biomes = $query->fetchAll(PDO::FETCH_ASSOC);
$threeFirstBiomes = array_slice($biomes, 0, 3);
?>

<?php foreach ($threeFirstBiomes as $biome) { ?>
    <a href="/biome/view">
        <div class="card-biome">
            <img src=<?php echo $biome['image_url'] ?> class="rounded w-100" alt=<?php echo $biome['image_alt'] ?>/>
            <h3><?php echo $biome['name'] ?></h3>
            <p><?php echo $biome['description'] ?></p>
        </div>
    </a>
<?php } ?>

