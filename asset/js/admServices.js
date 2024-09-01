import Service from './class/Service.js';

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

document.getElementById('sort-name')
    .addEventListener('click', () => sortName(table));

function sortName(table){
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);

    const icon = document.getElementById('sort-icon');
    let ascending = icon.classList.contains('bi-sort-alpha-down');

    // Sort the rows 
    rows.sort((a, b) => {
        const cellA = a.cells[0].textContent.trim().toLowerCase();
        const cellB = b.cells[0].textContent.trim().toLowerCase();

        if (ascending) {
            return cellA.localeCompare(cellB); // Ascendant
        } else {
            return cellB.localeCompare(cellA); // Descendant
        }
    });

    rows.forEach(row => tbody.appendChild(row));

    // Icon toogle
    if (ascending) {
        icon.classList.remove('bi-sort-alpha-down');
        icon.classList.add('bi-sort-alpha-down-alt');
    } else {
        icon.classList.remove('bi-sort-alpha-down-alt');
        icon.classList.add('bi-sort-alpha-down');
    }
}


table.addEventListener('click', function(event) {
    if (event.target.classList.contains('bi-trash')) {
        const serviceId = event.target.getAttribute('data-id');

        if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
            // Envoyer la requête AJAX pour supprimer l'élément
            fetch(`/DeleteService.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${serviceId}&_method=DELETE`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer la ligne du tableau
                    const row = event.target.closest('tr');
                    row.parentNode.removeChild(row);
                } else {
                    alert('Erreur lors de la suppression du service.');
                }
            })
            .catch(error => console.error('Erreur:', error));
        }
    } else if (event.target.classList.contains('bi-pencil-square')){
        const row = event.target.closest('tr');
            const cells = row.querySelectorAll('td');

            // Passer les cellules en mode édition
            cells.forEach((cell, index) => {
                if (index < cells.length - 1) { // Exclure la dernière colonne (actions)
                    const text = cell.textContent;
                    cell.innerHTML = `<input type="text" value="${text}" />`;
                }
            });

            // Ajouter un bouton "Sauvegarder" à la ligne
            const saveButton = document.createElement('button');
            saveButton.textContent = 'Sauvegarder';
            saveButton.classList.add('save-button');
            row.appendChild(saveButton);

            // Gestion du clic sur le bouton "Sauvegarder"
            saveButton.addEventListener('click', () => {
                const inputs = row.querySelectorAll('input');
                const updatedData = Array.from(inputs).map(input => input.value);
                const serviceId = row.querySelector('.bi-trash').getAttribute('data-id');

                fetch(`/UpdateService.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${serviceId}&name=${encodeURIComponent(updatedData[0])}&description=${encodeURIComponent(updatedData[1])}&alt=${encodeURIComponent(updatedData[2])}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour les cellules avec les nouvelles données
                        inputs.forEach((input, index) => {
                            cells[index].textContent = input.value;
                        });
                        row.removeChild(saveButton);
                    } else {
                        alert('Erreur lors de la mise à jour du service.');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });

    }
});

    
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

