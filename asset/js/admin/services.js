import Service from '../class/Service.js';

let services = [];

const table = document.getElementById('list-service');
const rows = table.querySelectorAll('tbody tr');
rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    const newService = new Service(
        cells[0].textContent, 
        cells[1].textContent, 
        cells[2].textContent, 
        cells[3].textContent  
    );
    services.push(newService);
});
// Afficher les données dans la console
services.forEach(function(service) {
    const serviceData = service.getService();
    console.log(`Nom: ${serviceData[0]}, Alt: ${serviceData[3]}`);
});

// // EventListener for button 'Ajouter'
// document.getElementById('newService')
//     .addEventListener('submit', e => {
//     e.preventDefault();
//     servicesTableHTMLt()
// });

// function addService(){
//     const form = document.getElementById("newService");
//     const name = document.getElementById("name").value;
//     const description = document.getElementById("description").value;
//     // à implemanter pour l'image
//     const alt = document.getElementById("alt").value;

//     if (name != "" && description != "" && alt != ""){
//         let newService = new Service(name, prenom, telephone);
//         contacts.push(newContact);
            
//         // showContacts(); 
//         contactTableHTML(newContact);
    
//         // efface les inputs
//             form.reset();
//     }
//     else{
//         window.alert("Merci de renseigner tous les champs.")
//     }
    
    
// }
// // affichage dans la console
// function showContacts(){ 
//     let contact = [];
//     for (const i of contacts) {
//         contact = i.getPersonne();
//         console.log(`Nom: ${i.name}, Prénom: ${i.forename}, Téléphone: ${i.phone}`);
//     }
// }
// affichage d'un tableau en HTML
// function servicesTableHTML(contact){
//     // Sélectionne le tbody de la table avec l'ID 'list-contact'
//     const myTable = document.querySelector("#list-contact tbody");
    
//     // Crée un nouvel élément <tr> pour ajouter une nouvelle ligne au tableau
//     const newRow = document.createElement('tr');

//     // Crée et ajoute des cellules <td> pour chaque propriété du contact
//     const tdName = document.createElement('td');
//     tdName.innerText = contact.name;
//     newRow.appendChild(tdName);
    
//     const tdForename = document.createElement('td');
//     tdForename.innerText = contact.forename;
//     newRow.appendChild(tdForename);

//     const tdPhone = document.createElement('td');
//     tdPhone.innerText = contact.phone;
//     newRow.appendChild(tdPhone);

//     // Crée et ajoute une cellule <td> et ajoute 2 boutons
//     const tdModif = document.createElement('td');
//     tdModif.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';
//     tdModif.addEventListener('click', function() {modifContact(contact, newRow);});
//     newRow.appendChild(tdModif);

//     const tdDelete = document.createElement('td');
//     tdDelete.innerHTML ='<i class="fa-solid fa-trash"></i>';
//     tdDelete.addEventListener('click', function() {newRow.remove();});
//     newRow.appendChild(tdDelete);

//     myTable.appendChild(newRow);
// }

// function modifContact(contact, row){
//     const tdName = row.children[0];
//     const tdForename = row.children[1];
//     const tdPhone = row.children[2];
//     const tdModif = row.children[3];  // Le bouton "Modifier"
//     const tdDelete = row.children[4]; // Le bouton "Supprimer"

//     // cache les bouton modifier et supprimer
//     tdModif.style.display = 'none';
//     tdDelete.style.display = 'none';

//     const inputName = document.createElement('input');
//     inputName.type = 'text';
//     inputName.value = tdName.innerText;
//     tdName.innerText = '';
//     tdName.appendChild(inputName);

//     const inputForename = document.createElement('input');
//     inputForename.type = 'text';
//     inputForename.value = tdForename.innerText;
//     tdForename.innerText = '';
//     tdForename.appendChild(inputForename);

//     const inputPhone = document.createElement('input');
//     inputPhone.type = 'tel';
//     inputPhone.value = tdPhone.innerText;
//     tdPhone.innerText = '';
//     tdPhone.appendChild(inputPhone);

    
//     const saveButton = document.createElement('span');
//     saveButton.innerHTML = '<i class="fa-solid fa-floppy-disk"></i>';
//     row.appendChild(saveButton);    
//     saveButton.addEventListener('click', function() {
//         contact.name = inputName.value;
//         contact.forename = inputForename.value;
//         contact.phone = inputPhone.value;

//         tdName.innerText = contact.name;
//         tdForename.innerText = contact.forename;
//         tdPhone.innerText = contact.phone;

//         row.removeChild(saveButton);
        
//         // Affiche de nouveau les boutons "Modifier" et "Supprimer"
//         tdModif.style.display = 'inline';
//         tdDelete.style.display = 'inline';
//     });
// }

