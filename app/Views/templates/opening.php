<?php 
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM opening');
$days = $query->fetchAll(\PDO::FETCH_ASSOC);
?>


<div id="opening-time">
    <div id="day">
        <div>Lundi :</div>
        <div>Mardi :</div>
        <div>Mercredi :</div>
        <div>Jeudi :</div>
        <div>vendredi :</div>
        <div>Samedi :</div>
        <div>Dimanche :</div>
    </div>
    <div id="opening-hours">
        <?php 
            foreach ($days as $day){
                if($day['closure']){
                   echo "<div>Fermeture</div>";
                } else {
                    echo "<div>"
                    .sprintf('%02d', $day['opening_hour'])
                    ."h".sprintf('%02d', $day['opening_minute'])
                    ." - "
                    .sprintf('%02d', $day['closing_hour'])
                    ."h".sprintf('%02d', $day['closing_minute'])
                    ."</div>";
                }
            }
        ?>
    </div>
</div>