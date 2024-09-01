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
        const row = event.target.closest('tr');

        if (confirm('Êtes-vous sûr de vouloir supprimer cette ligne?')) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'app/Controllers/DeleteService.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Réponse brute du serveur:', xhr.responseText); // Affichez la réponse brute
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            row.remove();
                            alert('Ligne supprimée avec succès.');
                        } else {
                            alert('Erreur lors de la suppression: ' + response.error);
                        }
                    } catch (e) {
                        console.error('Erreur lors de la conversion JSON:', e);
                    }
                }
            };
            xhr.send('id=' + encodeURIComponent(serviceId));
        }
    } else if (event.target.classList.contains('bi-pencil-square')){
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');

        // Cells in edition mode
        cells.forEach((cell, index) => {
            if (index < cells.length - 1) { // Exclude the last columne
                const text = cell.textContent;
                cell.innerHTML = `<input class=" col-12 edit-mode" type="text" value="${text}" />`;
            }
        });

        // Masquer les icônes d'action
        const actionCell = cells[cells.length - 1]
        actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
            icon.classList.add('hidden');
        });
        actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
            icon.classList.remove('hidden');
        });

    } else if (event.target.classList.contains('bi-x-circle')){
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');

        // Cells view mode
        cells.forEach((cell, index) => {
            if (index < cells.length - 1) { // Exclude the last columne
                const input = cell.querySelector('input');
                if (input) {
                    cell.innerHTML = input.value;
                }
            }
        });

        // Masquer les icônes d'action
        const actionCell = cells[cells.length - 1]
        actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
            icon.classList.remove('hidden');
        });
        actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
            icon.classList.add('hidden');
        });

    } else if (event.target.classList.contains('bi-floppy')) {
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');
        const inputs = row.querySelectorAll('input');
        const updatedData = Array.from(inputs).map(input => input.value);
        const serviceId = row.querySelector('.bi-trash').getAttribute('data-id');
        
        // Envoyer les données au serveur pour mettre à jour la base de données
        fetch('app/Controllers/UpdateService.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'id': serviceId,
                'name': updatedData[0],
                'description': updatedData[1],
                'image_url': updatedData[2],
                'image_alt': updatedData[3]
            }).toString()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour les cellules avec les nouvelles données
                inputs.forEach((input, index) => {
                    cells[index].textContent = input.value;
                });
                // Masquer les icônes de sauvegarde et d'annulation et afficher les icônes d'action
                const actionCell = cells[cells.length - 1];
                actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
                    icon.classList.add('hidden');
                });
                actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
                    icon.classList.remove('hidden');
                });
            } else {
                alert('Erreur lors de la mise à jour du service.');
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});

