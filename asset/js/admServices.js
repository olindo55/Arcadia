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


// need it for sort fnct
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



// POST
document.getElementById('addServicetButton').addEventListener('click', function(event){
    event.preventDefault();
    spinnerContainer.classList.remove('d-none');

    const form = document.getElementById('newService');
    const formData = new FormData(form);

    fetch('/admServices/post', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            const toast = new MyToast('Page non disponible', 'danger');
            toast.show();
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data.success) {
            addLine(data.data);
            const toast = new MyToast('Service ajouté avec succès.', 'success');
            toast.show();
        } 
        else {
            const toast = new MyToast(`Erreur lors de l'ajout du service: ${data.error}`, 'danger');
            toast.show();
        }
    })
    .catch(error => {
        // console.log(data);
        const toast = new MyToast(`Erreur lors de  l'ajout du service: ${error.message}`, 'danger');
        toast.show();
    })
    .finally(() => {
        spinnerContainer.classList.add('d-none');
    });
});

table.addEventListener('click', function(event) {
    // DELETE
    if (event.target.classList.contains('bi-trash')) {
        const id = {
            id: event.target.getAttribute('data-id')
        };
        const row = event.target.closest('tr');

        // Modal show
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer ce service ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            // DELETE - start             
            fetch('/admServices/delete', {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(id)
            })
            .then(response => {
                if (!response.ok) {
                    const toast = new MyToast('Page non disponible', 'danger');
                    toast.show();
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data.success) {
                    row.remove();
                    const toast = new MyToast(data.message, 'success');
                    toast.show();
                } 
                else {
                    const toast = new MyToast(`Erreur lors de la suppression du service: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la suppression du service: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
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
            const data = {
                id: serviceId,
                name: updatedData[0],
                description: updatedData[1],
                image_url: updatedData[2],
                image_alt: updatedData[3]
            }
            // UPDATE - start
            fetch('/admServices/put', {
                method: 'PUT',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    const toast = new MyToast('Page non disponible', 'danger');
                    toast.show();
                } else {
                    return response.json();
                }
            })
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
                    const toast = new MyToast(data.message, 'success');
                    toast.show();
                } 
                else {
                    const toast = new MyToast(`Erreur lors de la modification du service: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la modification du service: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            // UPDATE - end
            updateModal.hide()
        }
    }    
});

function addLine(data) {
    const table = document.getElementById('list-service').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    const nameCell = newRow.insertCell(0);
    const descriptionCell = newRow.insertCell(1);
    const imageUrlCell = newRow.insertCell(2);
    const altCell = newRow.insertCell(3);
    const actionsCell = newRow.insertCell(4);

    nameCell.textContent = data.name;
    descriptionCell.textContent = data.description;
    imageUrlCell.textContent = data.upload;
    altCell.textContent = data.alt;

    actionsCell.className = 'icon-cell';
    actionsCell.innerHTML = `
        <i class="bi bi-pencil-square"></i>
        <i class="bi bi-trash"></i>
        <i class="bi bi-x-circle hidden"></i>
        <i class="bi bi-floppy hidden"></i>
    `;
}
