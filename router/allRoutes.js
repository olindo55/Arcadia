import Route from "./Route.js";

//Définir ici les routes
export const allRoutes = [
    new Route("/", "Accueil", "/asset/pages/home.html", "/asset/js/home.js"),
    new Route("/contact", "Contact", "/asset/pages/contact.html", "/asset/js/contact.js"),
];

//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "Zoo Arcadia";