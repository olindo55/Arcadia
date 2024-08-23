import Route from "./Route.js";

//Défine the routes
export const allRoutes = [
    new Route("/", "Accueil", "/asset/pages/home.php", "/asset/js/home.js"),
    new Route("/contact", "Contact", "/asset/pages/contact.php", "/asset/js/contact.js"),
    new Route("/service", "Service", "/asset/pages/service.php", "/asset/js/service.js"),
    new Route("/cookie", "Cookie", "/asset/pages/cookie.php",),
    new Route("/biome", "Les animaux et leurs habitats", "/asset/pages/biome.php",),
    new Route("/signin", "Connexion", "/asset/pages/admin/signin.php", "/asset/js/signin.js"),
    new Route("/admin/animal", "Admin - Animaux", "/asset/pages/admin/animal.php",),
    new Route("/admin/biome", "Admin - Habitats", "/asset/pages/admin/biome.php",),
    new Route("/admin/comments", "Admin - Commentaires", "/asset/pages/admin/comments.php",),
    new Route("/admin/feeding", "Admin - Nourrissage", "/asset/pages/admin/feeding.php",),
    new Route("/admin/grant", "Admin - Droits et accès", "/asset/pages/admin/grant.php",),
    new Route("/admin/opening", "Admin - Horaires", "/asset/pages/admin/opening.php",),
    new Route("/admin/services", "Admin - Services", "/asset/pages/admin/services.php",),
    new Route("/admin/vet_report", "Admin - Rapports vetérinaires", "/asset/pages/admin/vetreport.php",),
];

//The title
export const websiteName = "Zoo Arcadia";