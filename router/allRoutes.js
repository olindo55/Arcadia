import Route from "./Route.js";

//Défine the routes
export const allRoutes = [
    new Route("/", "Accueil", "/asset/pages/home.php", "/asset/js/home.js"),
    new Route("/contact", "Contact", "/asset/pages/contact.php", "/asset/js/contact.js"),
    new Route("/signin", "Connexion", "/asset/pages/signin.php", "/asset/js/signin.js"),
    new Route("/service", "Service", "/asset/pages/service.php", "/asset/js/service.js"),
];

//The title
export const websiteName = "Zoo Arcadia";