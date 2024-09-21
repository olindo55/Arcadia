<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/',$uri);
if (count($uriParts) === 2 && $uriParts[1] === '') {
    $uriParts[1] = 'homepage';
    $uriParts[2] = 'view';
}
unset($uriParts[0]);

$controller = ucfirst($uriParts[1]);
$method = ucfirst($uriParts[2]);

$controllerName = 'App\\Controllers\\'.$controller;
$controller = new $controllerName;

$jsFile = '/asset/js/'.$uriParts[1].'.js';

$error = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_FILES)){
        $result = $controller->$method($_POST, $_FILES);
    }
    else {
        $result = $controller->$method($_POST);
    }
    if ($result !== true){
        $error = $result;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    return $controller->$method();
    if ($result !== true){
        $error = $result;
    }
}
else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    return $controller->$method();
    if ($result !== true){
        $error = $result;
    }
}
else {
    $page = $controller->$method();
}

$flashMessage = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashAlert =$_SESSION['flash_alert'];
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_alert']);
}
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($uriParts[1]) ?> - Arcadia</title>
    <meta name="description" content="Le Zoo Arcadia vous invite à explorer son site web pour en apprendre davantage sur ses animaux et leurs habitats, les services offerts par le zoo et ses horaires."/>
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="asset/images/logo/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="asset/images/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="asset/images/logo/favicon/favicon-16x16.png">
    <link rel="manifest" href="asset/images/logo/favicon/site.webmanifest">
    <link rel="mask-icon" href="asset/images/logo/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
 
    
    <!-- Bootstrap 5.3.3 -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/asset/scss/style.css">
    <!-- Swiper -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
     
</head>
    <body>
        <header>
            <div class="main-nav" >
                <div id="logo" onclick="window.location.href ='/'">
                    <img src="/asset/images/logo/print_blur.png" alt="Logo du Zoo Arcadia représentant une empreinte de mammifère">
                    <div>
                        <h1>Zoo Arcadia</h1>
                        <h2>pour la Faune, par Nature</h2>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li class="<?= $uriParts[1] == 'homepage' ? 'active' : '' ?>"><a href="/">Accueil</a></li>
                        <li class="<?= $uriParts[1] == 'biome' ? 'active' : '' ?>"><a href="/biome/view">Le zoo</a></li>
                        <li class="<?= $uriParts[1] == 'service' ? 'active' : '' ?>"><a href="/service/view">Services</a></li>
                        <li class="<?= $uriParts[1] == 'contact' ? 'active' : '' ?>"><a href="/contact/view">Contactez-nous</a></li>
                    </ul>
                </nav>
                
                <div id="nav-buttons">
                    <?php require 'app/Views/templates/button-connection-adm.php' ?>
                </div>
                <div class="my-burger-button">
                    <i class="bi bi-list text-light" style="font-size: 33px"></i> <!-- burger icon -->
                </div>
            </div>
            
            <!-- start burger menu-->
            <div class="my-burger-menu">
                <ul>
                    <li class="<?= $uriParts[1] == 'homepage' ? 'active' : '' ?>"><a href="/">Accueil</a></li>
                    <li class="<?= $uriParts[1] == 'biome' ? 'active' : '' ?>"><a href="/biome/view">Le zoo</a></li>
                    <li class="<?= $uriParts[1] == 'service' ? 'active' : '' ?>"><a href="/service/view">Services</a></li>                       
                    <li class="<?= $uriParts[1] == 'contact' ? 'active' : '' ?>"><a href="/contact/view">Contactez-nous</a></li>
                    <hr>
                    <!-- Connection button -->
                    <?php require 'app/Views/templates/button-connection-adm-bgr.php' ?>
                </ul>
            </div>
            <!-- end burger menu-->
        </header>
        <main id="main-page">
            
            <!-- Injection page - start-->
            <?php require_once $page ?>
            <!-- Injection page - end-->



            <!-- Modal -->
            <div class="modal" id="confirmModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalBasicLabel">Confirmation</h5>
                            <button type="button" class="btn-close" id="modal-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" id="cancelButton" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger" id="confirmButton">...</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast -->
            <div  role="alert" aria-live="assertive" aria-atomic="true" class="position-fixed top-0 end-0 p-3">
                <div id="toast-container">
                    <!-- Toasts will be dynamically added by php -->
                </div>
            </div>

            <!-- Spinner -->
            <div id="spinner-container" class="d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>


        </main>
        <footer>
            <div id="my-container">
                <div id="opening">
                    <div id="opening-title">Horaires d'ouverture</div>
                    <?php require_once 'app/Views/templates/opening.php' ?>
                </div>
                
                <address>
                    <h3>Zoo Arcadia</h3>
                    <div id="adress">
                        <div>18, route de Merlin l’enchanteur</div>
                        <div>Forêt de Brocéliande</div>
                        <div>35380 Paimpont, France</div>
                    </div>
                    <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href = '/contact/view'"><i class="bi bi-envelope"></i> Contactez-nous</button>
                </address>
        
                <div id="social-network">
                    <div id="title-social">Retrouvez nous aussi sur :</div>
                    <div id="icons-social">
                        <a href="http://facebook.com/" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="http://snapchat.com/" target="_blank"><i class="bi bi-snapchat"></i></a>
                        <a href="http://instagram.com/" target="_blank"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div id="copyright">
                <div>© Zoo Arcadia 2024</div>
                <a href="/cookie/view">Politique de gestion des cookies</a>
            </div>
        </footer>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <!-- <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> <!-- swiper -->
    <script type="module" src="/asset/js/menu.js"></script>
    <script type="module" src="/asset/js/signin.js"></script>
    <script type="text/javascript">
        // Variables PHP injectées dans le JS
        const flashMessage = <?php echo json_encode($flashMessage); ?>;
        const flashAlert = <?php echo json_encode($flashAlert); ?>;
        </script>
    <!-- <script type="module" src="/router/router.js"></script> -->
    <!-- Management of script's page -->
     <?php 
        echo '<script type="module" src="'.$jsFile.'"></script>' ;  
     ?>
</body>
</html>


