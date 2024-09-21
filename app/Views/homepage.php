<section id="scene-home">
    <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade my-carousel" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
          <img src="/asset/images/animals/jungle/angel-luciano-zTGzwYKXC-A-unsplash.jpg" class="d-block w-100" alt="Flamands roses">
        </div>
        <div class="carousel-item" data-bs-interval="5000">
          <img src="/asset/images/animals/jungle/jared-rice-O6DUoIl6NWA-unsplash.jpg" class="d-block w-100" alt="Tigre allongé">
        </div>
        <div class="carousel-item" data-bs-interval="5000">
          <img src="/asset/images/animals/savane/mediaecke-pYTgvmpuQWs-unsplash.jpg" class="d-block w-100" alt="...">
        </div>
      </div>
    </div> 
    <div class="title">
      <h1>Zoo Arcadia</h1>
      <h2>pour la Faune, par Nature</h2>
    </div> 
</section>

<section id="biome-home">
  <div class="title">
      <h2>Découvrez l'univers de nos animaux<span class="point">.</span></h2>
  </div>
  <!-- cards biome - start -->
  <div id="my-carousel-biome-home">
    <?php include 'templates/card-biome-home.php';?>
  </div>
  <!-- cards biome - stop -->
  <button type="button" onclick="window.location.href ='/biome/view'" class="btn btn-secondary btn-lg shadow-sm mt-2 my-button-desktop">Découvrir +</button>
</section>

<section id="service-home">
  <h2>Nos services<span class="point">.</span></h2>
  <div id="service-container">
    <div id="text-service">
      <p>Bienvenue au Zoo Arcadia, un lieu dédié à la découverte et à la protection de la faune sauvage. Situé au cœur d’un environnement naturel exceptionnel, la forêt de Brocéliande,  notre zoo offre une multitude de services conçus pour rendre votre visite non seulement agréable, mais aussi éducative et inspirante. Que vous soyez un passionné de la nature, un amateur d'animaux ou une famille en quête d'aventures, nos services sont pensés pour répondre à vos besoins et surpasser vos attentes.</p>
      <button type="button" onclick="window.location.href ='/service/view'" class="btn btn-secondary btn-lg shadow-sm mt-2 my-button-desktop">En savoir +</button>
    </div>      
    <div class="swiper swiperService">
      <div class="swiper-wrapper">
        <!-- card-service -->
        <?php include 'templates/card-service.php';?>
      </div>
      <div class="swiper-button-next"><img src="../../asset/images/logo/leaf_right.png" alt="fleche droite en forme de feuille">
      </div>
      <div class="swiper-button-prev"><img src="../../asset/images/logo/leaf_left.png" alt="fleche gauche en forme de feuille">
      </div>
    </div>  
  </div>
  <button type="button" onclick="window.location.href ='/service/view'" class="btn btn-secondary btn-lg shadow-sm mt-2 my-button-phone">En savoir +</button>
</section>

<section id="comments-home">
  <div id="comments">
    <div class="swiper swiperComment">
      <div class="swiper-wrapper">
        <!-- card-comments -->
        <?php include 'templates/card-comments.php';?>
      </div>
    </div>
  </div>
  <form id="form-comment" method="post">
    <h2>Laissez votre commentaire<span class="point">.</span></h2>
    <div class="mb-3">
      <label for="pseudo" class="form-label">Nom/Pseudo*</label>
      <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="ici mon pseudo..." >
      <div class="valid-feedback">
        ok!
      </div>
      <div class="invalid-feedback">
        Merci de renseigner votre nom ou pseudo.
      </div>
    </div>
    <div class="mb-3">
      <label for="comment" class="form-label">Commentaire*</label>
      <textarea class="form-control" id="comment" name="comment" rows="6"></textarea>
      <div class="valid-feedback">
        ok!
      </div>
      <div class="invalid-feedback">
        Merci de rédiger votre commentaire.
      </div>
    </div>
    <div id="footer-comment">
      <div class="my-stars">
        <span class="my-star" data-value="5">★</span>
        <span class="my-star" data-value="4">★</span>
        <span class="my-star" data-value="3">★</span>
        <span class="my-star" data-value="2">★</span>
        <span class="my-star" data-value="1">★</span>
      </div>
      <input  type="hidden" id="ratingValue" name="ratingValue" value="0">
      <button type="submit" class="btn btn-secondary btn-lg shadow-sm mt-2" id="btn-form-comment" disabled>Envoyer</button>
    </div>
  </form>
</section>



