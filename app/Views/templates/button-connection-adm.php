<?php if(isset($_SESSION['connected']) && $_SESSION['connected']) : ?>
    <li class="nav-item dropdown">
        <button type="button" class="btn btn-secondary">Administration</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur') : ?>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admUsers' ? 'active' : '' ?>" href="/admUsers/view">Droits et utilisateurs</a></li>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admServices' ? 'active' : '' ?>" href="/admServices/view">Services</a></li>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admOpening' ? 'active' : '' ?>" href="/admOpening/view">Horaires</a></li>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admBiomes' ? 'active' : '' ?>" href="/admBiomes/view">Habitats</a></li>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admAnimals' ? 'active' : '' ?>" href="/admAnimals/view">Animaux</a></li>
            <?php elseif(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'vétérinaire')): ?>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admVet' ? 'active' : '' ?>"a href="/admVet/view">Rapports vétérinaire</a></li>
            <?php elseif(isset($_SESSION['role']) && ($_SESSION['role'] === 'administrateur' || $_SESSION['role'] === 'employé')): ?>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admFeedings' ? 'active' : '' ?>" href="/admFeeding/view">Nourrissages</a></li>
                <li><a class="dropdown-item <?= $uriParts[1] == 'admComments' ? 'active' : '' ?>" href="/admComments/view">Avis</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" id="signout" href="/login/signout">Déconnexion</a></li>
        </ul>
        <h6><?php echo $_SESSION['role'] ?></h6>
    </li>
    
<?php else : ?>
    <div class="dropdown">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            Connexion
        </button>
        <form method="post" class="dropdown-menu p-4" id="login-form">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="votre mot de passe">
        </div>
        <button type="submit" class="btn btn-primary" id="login-button">Connecter</button>
    </form>
    </div>
<?php endif; ?>