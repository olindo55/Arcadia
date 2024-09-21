import TableSort from './class/TableSort.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

const spinnerContainer = document.getElementById('spinner-container');

const table = document.getElementById('list-vet');

let tableSorter;

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    
    // Sort
    // ------
    tableSorter = new TableSort(table);
    const headers = table.querySelectorAll('thead th');
    headers[0].addEventListener('click', () => {
        tableSorter.sortColumn(0, 'sort-icon-name');
    });
    headers[1].addEventListener('click', () => {
        tableSorter.sortColumn(1, 'sort-icon-date');
    });

    // Filter
    // -------
    const searchByName = document.getElementById('searchByAnimal');
    const searchByDate = document.getElementById('searchByDate');

    function applyFilters() {
        const inputName = searchByName.value.toLowerCase(); 
        const inputDate = searchByDate.value; 

        const rows = document.querySelectorAll('#list-vet tbody tr'); 

        rows.forEach(function(row) {
            const animalName = row.querySelector('.animal-name').textContent.toLowerCase(); 
            const fullDateReport = row.querySelector('.date-report').textContent.trim(); 
            const dateOnly = fullDateReport.split(' ')[0]; 

            const matchName = animalName.indexOf(inputName) > -1 || inputName === '';
            const matchDate = dateOnly === inputDate || inputDate === '';

            if (matchName && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchByName.addEventListener('keyup', applyFilters);
    searchByDate.addEventListener('change', applyFilters);
});

document.querySelectorAll('.bi-eye').forEach(icon => {
    icon.addEventListener('click', function() {
        spinnerContainer.classList.remove('d-none');

        const id = this.getAttribute('data-id');
        console.log('ID à envoyer:', id);
        // stock ID in session
        fetch('/app/Database/set_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', 
            },
            body: `id=${encodeURIComponent(id)}`
        })
        .then(response => {
            if (response.ok) {
                // Recharger la page
                location.reload();
            }
        })
        .then(data => {
            console.log('Réponse du serveur:', data);
            if (data.status === 'success') {
                location.reload();
            } else {
                console.error('Erreur:', data.message);
            }
        })
        .finally(() => {
            spinnerContainer.classList.add('d-none');
        });
    });
});

document.querySelector('.myButtonAdd').addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();

    // POST
    document.getElementById('addReportButton').addEventListener('click', function(event){
        event.preventDefault();
        spinnerContainer.classList.remove('d-none');

        const form = document.getElementById('admForm');
        const formData = new FormData(form);

        // for (const [key, value] of formData.entries()) {
        //     console.log(`${key}: ${value}`);
        // }

        fetch('/admVet/post', {
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
                form.reset();
                // modal.hide();
                setTimeout(() => {
                    location.reload();
                  }, 2000);
                
            } 
            else {
                const toast = new MyToast(data.message, 'danger');
                toast.show();
            }
        })
        .catch(error => {
            const toast = new MyToast(`Erreur lors de  l'ajout du rapport: ${error.message}`, 'danger');
            toast.show();
        })
        .finally(() => {
            spinnerContainer.classList.add('d-none');
        });
    });
});

const animalSelect = document.getElementById('animal-select');
const biomeDisplay = document.getElementById('biome-by-animal');

animalSelect.addEventListener('change', function () {
    const selectedOption = animalSelect.options[animalSelect.selectedIndex];
    const biome = selectedOption.getAttribute('data-bio');
    biomeDisplay.textContent = biome.charAt(0).toUpperCase() + biome.slice(1).toLowerCase();;
});


function addLine(data) {
    const table = document.getElementById('list-vet').getElementsByTagName('tbody')[0];
    const rowCount = table.rows.length;
    const newRow = table.insertRow();

    const nameCell = newRow.insertCell(0);
    const dateCell = newRow.insertCell(1);
    const actionsCell = newRow.insertCell(2);
    nameCell.textContent = data.animal_name;
    dateCell.textContent = data.date;

    actionsCell.className = 'icon-cell';
    actionsCell.innerHTML = `<i class="bi bi-eye" data-id="${rowCount}"></i>`;

}
