<?php require_once 'config/config.php'; ?>

<form class="container-fluid col-10 col-md-4 py-3 contact-form" >
    <div class="col-10 pb-3">
        <label for="email" class="form-label">Votre email</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <input type="email" class="form-control" id="email" aria-describedby="inputGroupPrepend" required="">
          <div class="valid-feedback">
              ok!
          </div>
          <div class="invalid-feedback">
            Merci de renseigner une adresse email valide.
          </div>
        </div>
    </div>
    <div class="col-10 pb-3">
      <label for="subject" class="form-label">Objet</label>
      <input type="text" class="form-control" id="subject">
      <div class="valid-feedback">
        ok!
      </div>
      <div class="invalid-feedback">
        Merci de renseigner l'objet de votre email.
      </div>
    </div>
    <div class="col-10 pb-3">
      <label for="message" class="form-label">Message</label>
      <textarea class="form-control" id="message" style="height: 200px"></textarea>
      <div class="valid-feedback">
        ok!
      </div>
      <div class="invalid-feedback">
        Merci d'ajouter votre message.
      </div>
    </div>
    <div class="col-10 mt-3 text-center">
      <button class="btn btn-primary" id='btnForm' type="button" disabled>Envoyer</button>
    </div>
  </form>