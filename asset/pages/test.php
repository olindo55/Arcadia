<!-- <?php require_once 'config/config.php'; ?> -->

<div class="container mt-5">
    <button class="btn btn-primary" id="showAlertButton" type="button" onclick="document.getElementById('successAlert').style.display = 'block';">Appuyez ici</button>
    <div class="alert alert-success mt-3" id="successAlert" role="alert" style="display: none;">
      Alerte de succès affichée après avoir cliqué sur le bouton !
    </div>
</div>

<!-- <script>
    document.getElementById('showAlertButton').addEventListener('click', function() {
        document.getElementById('successAlert').style.display = 'block';
    });
</script> -->