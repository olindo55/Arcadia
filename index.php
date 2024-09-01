<?php
require_once __DIR__.'/vendor/autoload.php';

$pageName = $_GET['page'] ?? 'home';
$page = 'app/Views/'.$pageName.'.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controllerName = 'App\\Controllers\\'.ucfirst($pageName);
    $controller = new $controllerName;
    if(isset($_FILES)){
        $result = $controller->managePostForm($_POST, $_FILES);
    }
    else {
        $result = $controller->managePostForm($_POST);
    }
    
    if ($result != ""){
        $error = $result;
    }
}

    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Arcadia</title>
    <meta name="description" content="Le Zoo Arcadia vous invite à explorer son site web pour en apprendre davantage sur ses animaux et leurs habitats, les services offerts par le zoo et ses horaires."/>
    <!-- Bootstrap 5.3.3 -->
     <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
     
     <link rel="stylesheet" href="./asset/scss/style.css">
    <!-- Swiper -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
     
</head>
    <body>
        <header>
            <div class="main-nav" >
                <div id="logo" onclick="window.location.href ='index.php?page=home'">
                    <img src="./asset/images/logo/print_blur.png" alt="Logo du Zoo Arcadia représentant une empreinte de mammifère">
                    <div>
                        <h1>Zoo Arcadia</h1>
                        <h2>pour la Faune, par Nature</h2>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li class="active"><a href="index.php?page=home">Accueil</a></li>
                        <li><a href="index.php?page=biome">Le zoo</a></li>
                        <li><a href="index.php?page=service">Services</a></li>
                    </ul>
                </nav>
                <div id="nav-buttons">
                    <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href ='index.php?page=contact'"><i class="bi bi-envelope"></i> Contactez-nous</button>
                    <div id="button-login">
                        <a href="index.php?page=signin">
                            <i class="bi bi-person text-dark" style="font-size: 45px"></i>
                        </a>
                    </div>   
                    <p><?php echo (isset($_SESSION['user']['forename']) ? $_SESSION['user']['forename'] : 'Visiteur');?></p>
                </div>
                <div class="my-burger-button">
                    <i class="bi bi-list text-light" style="font-size: 33px"></i> <!-- burger icon -->
                </div>
            </div>
            
            <!-- start burger menu-->
            <div class="my-burger-menu">
                <ul>
                    <li class="active"><a href="index.php?page=home">Accueil</a></li>
                    <li><a href="index.php?page=biome">Le zoo</a></li>
                    <li><a href="index.php?page=service">Services</a></li>
                </ul>
                <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href ='index.php?page=contact'"><i class="bi bi-envelope"></i> Contactez-nous</button>
                
                <!-- <button class="btn btn-secondary rounded-5 d-flex align-items-center justify-content-center">
                    <i class="bi bi-envelope me-2"></i> Contactez-nous
                </button> -->
                <div class="my-divider"></div>
                <div id="button-login">
                    <a href="index.php?page=signin">
                        <i class="bi bi-person text-dark" style="font-size: 45px"></i>
                    </a>
                    <p><?php echo $_SESSION['user']['forename']?></p>
                </div> 
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Annuler</button>
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
                            <div>Fermeture</div>
                            <div>09h00 - 18h00</div>
                            <div>09h00 - 18h00</div>
                            <div>09h00 - 18h00</div>
                            <div>09h00 - 18h00</div>
                            <div>09h00 - 18h00</div>
                            <div>09h00 - 18h00</div>
                        </div>
                    </div>
                </div>
                
                <address>
                    <h3>Zoo Arcadia</h3>
                    <div id="adress">
                        <div>18, route de Merlin l’enchanteur</div>
                        <div>Forêt de Brocéliande</div>
                        <div>35380 Paimpont, France</div>
                    </div>
                    <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href = 'index.php?page=contact'"><i class="bi bi-envelope"></i> Contactez-nous</button>
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
                <a href="index.php?page=cookie">Politique de gestion des cookies</a>
            </div>
        </footer>

    <!-- Script -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> <!-- swiper -->
    <script type="module" src="/asset/js/menu.js"></script>
    <!-- <script type="module" src="/router/router.js"></script> -->
    <!-- Management of script's page -->
     <?php 
        $jsFile = 'asset/js/'.$pageName.'.js';
        echo '<script type="module" src="'.$jsFile.'"></script>' ;  
     ?>
</body>
</html>


