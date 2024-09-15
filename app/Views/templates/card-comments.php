<?php
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM comment WHERE published = true ORDER BY date_comment DESC;');
$comments = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($comments as $comment) {

    $date_comment = strtotime($comment['date_comment']);
    $current_date = time();
    $diff_seconds = $current_date - $date_comment;
    $diff_days = floor($diff_seconds / (60 * 60 * 24));

    if ($diff_days == 0) {
        $days_ago = "aujourd'hui";
    } elseif ($diff_days == 1) {
        $days_ago = "il y a 1 jour";
    } else {
        $days_ago = "il y a $diff_days jours";
    }
    ?>

  <div class="swiper-slide">
    <div class="comment-card">
      <div class="header-comment">
        <h4><?php echo $comment['pseudo'] ?></h4>
        <h5><?php echo $days_ago; ?></h5>
      </div>
      <p><?php echo $comment['comment'] ?></p>
      <div class="stars">
      <?php
          for ($i = 1; $i <= 5; $i++) {
              if ($i <= $comment['score']) {
                  echo '<span class="star selected">★</span>';
              } else {
                  echo '<span class="star">★</span>';
              }
          }
          ?>
      </div>
    </div>
  </div>
<?php } ?>
 