<?php
require_once '../config/config.php';

$error = null;

// test si la méthode envoyée est bien POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$_POST['username'] || !$_POST['password']) {
        $error = 'Identifiants invalides';
    } else {
        $query = DbConnection::getPdo()->prepare('SELECT * FROM users WHERE email = :username');
        $query->bindParam('username', $_POST['username']);
        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if (!$users) {
            $error = 'Identifiants invalides';
        } else {          
            foreach($users as $user){
              if($user['email'] === $_POST['username']){
                $passwordOk = ($_POST['password'] == $user['password']) ? true : false; // verif mdp hashé >>>>>> $passwordOk = password_verify($_POST['password'], $user['password']);
              }
            }
            if (!$passwordOk) {
                $error = 'Identifiants invalides';
            } else {
                unset($user['password']);
                $_SESSION['user'] = $user;
                $_SESSION['success_message'] = "Bienvenue ".$_SESSION['user']['forename']." !";
                // // si ok on redirige
                // header('Location: ../home.php');
            }
        }
    }
}
?>

<?php if ($error): ?>
  <div class="alert alert-warning" role="alert">
      <?php echo $error; ?>
  </div>
<?php endif; ?>
<?php if (isset($_SESSION['success_message'])): ?>
  <div class="alert alert-success" role="alert">
      <?php
      echo $_SESSION['success_message'];
      unset($_SESSION['success_message']);
      ?>
  </div>
<?php endif; ?>

<form class="container-fluid col-10 col-md-4 py-3" id="signin-form" method="POST">
    <div class="col-10 pb-3">
        <label for="username" class="form-label">Votre identifiant</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <input type="email" class="form-control" id="username" name="username" aria-describedby="inputGroupPrepend" required="">
          <div class="valid-feedback">
              ok!
          </div>
          <div class="invalid-feedback login-feedback">
            Merci de renseigner une adresse email valide.
          </div>
        </div>
    </div>
    <div class="col-10 pb-3">
      <label for="password" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" id="password" name="password">
      <div class="valid-feedback">
        ok!
      </div>
      <div class="invalid-feedback">
        Merci de renseigner votre mot de passe.
      </div>
    </div>
    <div class="col-10 mt-3 text-center">
      <button class="btn btn-primary" id='btnForm' type="submit" >Connexion</button> <!-- disabled -->
    </div>
  </form>


  