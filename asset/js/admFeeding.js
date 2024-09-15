import TableSort from './class/TableSort.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

const spinnerContainer = document.getElementById('spinner-container');

const table = document.getElementById('list-feeding');

let tableSorter;

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    
    // Sort
    tableSorter = new TableSort(table);
    const headers = table.querySelectorAll('thead th');
    headers[0].addEventListener('click', () => {
        tableSorter.sortColumn(0, 'sort-icon-animal');
    });
    headers[1].addEventListener('click', () => {
        tableSorter.sortColumn(1, 'sort-icon-qte');
    });
    headers[2].addEventListener('click', () => {
        tableSorter.sortColumn(2, 'sort-icon-food');
    });
    headers[3].addEventListener('click', () => {
        tableSorter.sortColumn(3, 'sort-icon-date');
    });
    headers[4].addEventListener('click', () => {
        tableSorter.sortColumn(4, 'sort-icon-employee');
    });
});

// POST
document.getElementById('addFoodButton').addEventListener('click', function(event){
    event.preventDefault();
    spinnerContainer.classList.remove('d-none');

    const form = document.getElementById('admForm');
    const formData = new FormData(form);

    fetch('/admFeeding/post', {
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
            const toast = new MyToast(data.message, 'success');
            toast.show();
        } 
        else {
            const toast = new MyToast(data.message, 'danger');
            toast.show();
        }
    })
    .catch(error => {
        const toast = new MyToast(`Erreur lors du rapport : ${error.message}`, 'danger');
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
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer ce rapport ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');

            fetch('/admFeeding/delete', {
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
                    const toast = new MyToast(`Erreur lors de la suppression du rapport: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la suppression du rapport: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            deleteModal.hide()
        }
    }
    
});

function addLine(data) {

    fetch('/admFeeding/getInfo', {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then(response => {    
        if (!response.ok) {
        throw new Error('Les données sont manquantes');
        }
        return response.json();
    })
    .then(responseData => {
        const jsonData = responseData.data;

        const table = document.getElementById('list-feeding').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        
        const animalCell = newRow.insertCell(0);
        const qteCell = newRow.insertCell(1);
        const foodCell = newRow.insertCell(2);
        const dateCell = newRow.insertCell(3);
        const employeeCell = newRow.insertCell(4);
        const actionsCell = newRow.insertCell(5);
        
        const animalMap = createIdNameMap(jsonData.animals);
        const userMap = createIdNameMap(jsonData.users);
        const userForenameMap = createIdForeNameMap(jsonData.users);

        animalCell.textContent = getNameById(data.animal,animalMap);
        qteCell.textContent = data.qte;
        foodCell.textContent = data.food;
        dateCell.textContent = data.date;
        employeeCell.textContent = getNameById(data.employee,userMap) + ' ' + getNameById(data.employee,userForenameMap);
    
        actionsCell.className = 'icon-cell';
        actionsCell.innerHTML = `
            <i class="bi bi-trash" data-id="${data.id}"></i>
        `;
    })
    .catch(error => {
        console.error('Erreur:', error);
    })
    .finally(() => {
        spinnerContainer.classList.add('d-none');
    });



}

function createIdNameMap(items) {
    const map = {};
    items.forEach(item => {
        map[item.id] = item.name;
    });
    return map;
}
function createIdForeNameMap(items) {
    const map = {};
    items.forEach(item => {
        map[item.id] = item.forename;
    });
    return map;
}

function getNameById(id, map) {
    return map[id] || 'Nom non trouvé';
}



