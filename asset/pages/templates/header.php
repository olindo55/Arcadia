<?php
require_once 'C:/Env/Workspace/Arcadia/asset/pages/config/config.php';
?>

<body>
    <header>
        <div class="main-nav" >
            <div id="logo" onclick="window.location.href ='/'">
                <img src="./asset/images/logo/print_blur.png" alt="Logo du Zoo Arcadia représentant une empreinte de mammifère">
                <div>
                    <h1>Zoo Arcadia</h1>
                    <h2>pour la Faune, par Nature</h2>
                </div>
            </div>
            <nav>
                <ul>
                    <li class="active"><a href="/">Accueil</a></li>
                    <li><a href="/biome">Le zoo</a></li>
                    <li><a href="/service">Services</a></li>
                </ul>
            </nav>
            <div id="nav-buttons">
                <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href ='/contact'"><i class="bi bi-envelope"></i> Contactez-nous</button>
                <div id="button-login">
                    <a href="/signin">
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
                <li class="active"><a href="/">Accueil</a></li>
                <li><a href="/biome">Le zoo</a></li>
                <li><a href="/service">Services</a></li>
            </ul>
            <button class="btn btn-secondary rounded-5" type="button" onclick="window.location.href ='/contact'"><i class="bi bi-envelope"></i> Contactez-nous</button>
            
            <!-- <button class="btn btn-secondary rounded-5 d-flex align-items-center justify-content-center">
                <i class="bi bi-envelope me-2"></i> Contactez-nous
            </button> -->
            <div class="my-divider"></div>
            <div id="button-login">
                <a href="/signin">
                    <i class="bi bi-person text-dark" style="font-size: 45px"></i>
                </a>
                <p><?php echo $_SESSION['user']['forename']?></p>
            </div> 
        </div>
        <!-- end burger menu-->
    </header>
    <main id="main-page">
