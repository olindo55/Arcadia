import Service from './class/Service.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

let services = [];

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
});
const spinnerContainer = document.getElementById('spinner-container');






// --------------------------
// ------   Table   ---------
// --------------------------

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
    // DELETE
    if (event.target.classList.contains('bi-trash')) {
        const serviceId = event.target.getAttribute('data-id');
        const row = event.target.closest('tr');

        // Modal show
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer ce service ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            // DELETE - start                
            fetch('app/Controllers/DeleteService.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': serviceId
                }).toString() 
            })
            .then(data => {
                if (data.ok) {
                    row.remove();
                    const toast = new MyToast('Service supprimé avec succès.', 'success');
                    toast.show();
                    spinnerContainer.classList.add('d-none');
                } else {
                    const toast = new MyToast('Erreur lors de la suppression du service.', 'danger');
                    toast.show();
                    spinnerContainer.classList.add('d-none');
                }
            })
            .catch(error => {
                const toast = new MyToast('Erreur lors de la suppression du service. ' + error, 'danger');
                toast.show();
                spinnerContainer.classList.add('d-none');
            })
            // DELETE - end
            deleteModal.hide()
        }

    } 
    // UPDATE edition
    else if (event.target.classList.contains('bi-pencil-square')){
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');

        // original data in var just in case of cancel
        row.dataset.originalValues = JSON.stringify(Array.from(cells).slice(0, -1).map(cell => cell.textContent.trim()));

        // Cells in edition mode
        cells.forEach((cell, index) => {
            if (index < cells.length - 1) { // Exclude the last columne
                const text = cell.textContent;
                cell.innerHTML = `<input class=" col-12 edit-mode" type="text" value="${text}" />`;
            }
        });

        // Hide the other icons
        const actionCell = cells[cells.length - 1]
        actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
            icon.classList.add('hidden');
        });
        actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
            icon.classList.remove('hidden');
        });
    } 
    // UPDATE cancel
    else if (event.target.classList.contains('bi-x-circle')){
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');

        const originalValues = JSON.parse(row.dataset.originalValues);

        // Cells view mode
        cells.forEach((cell, index) => {
            if (index < cells.length - 1) { // Exclude the last column
                cell.textContent = originalValues[index];
            }
        });

        // Hide icoons
        const actionCell = cells[cells.length - 1]
        actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
            icon.classList.remove('hidden');
        });
        actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
            icon.classList.add('hidden');
        });
    } 
    // UPDATE !
    else if (event.target.classList.contains('bi-floppy')) {
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');
        const inputs = row.querySelectorAll('input');
        const updatedData = Array.from(inputs).map(input => input.value);
        const serviceId = row.querySelector('.bi-trash').getAttribute('data-id');

        // Modal show
        const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier ce service ?', 'Modifier');
        updateModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            // AJAX for UPDATE - start
            fetch('app/Controllers/UpdateService.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'type': 'UPDATE',
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
                    // Update the cells with the new datas
                    inputs.forEach((input, index) => {
                        cells[index].textContent = input.value;
                    });
                    // Hide and show the icons
                    const actionCell = cells[cells.length - 1];
                    actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
                        icon.classList.add('hidden');
                    });
                    actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
                        icon.classList.remove('hidden');
                    });
                    const toast = new MyToast('Service mis à jour avec succès.', 'success');
                    toast.show();
                    spinnerContainer.classList.add('d-none');
                } else {
                    const toast = new MyToast('Erreur lors de la mise à jour.', 'danger');
                    toast.show();
                    spinnerContainer.classList.add('d-none');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                spinnerContainer.classList.add('d-none');
            })
            // AJAX for UPDATE - end
            updateModal.hide()
        }
    }    
});
