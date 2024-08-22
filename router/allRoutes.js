import Route from "./Route.js";

//Défine the routes
export const allRoutes = [
    new Route("/", "Accueil", "/asset/pages/home.html", "/asset/js/home.js"),
    new Route("/contact", "Contact", "/asset/pages/contact.html", "/asset/js/contact.js"),
    new Route("/signin", "Connexion", "/asset/pages/signin.html", "/asset/js/signin.js"),
    new Route("/service", "Service", "/asset/pages/service.html", "/asset/js/service.js"),
];

//The title
export const websiteName = "Zoo Arcadia";