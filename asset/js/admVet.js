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
                modal.hide();
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




// table.addEventListener('click', function(event) {

//     // DELETE
//     if (event.target.classList.contains('bi-trash')) {
//         const id = {
//             id: event.target.getAttribute('data-id')
//         };
//         const row = event.target.closest('tr');

//         // Modal show
//         const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer les informations concernant cette race ?', 'Supprimer');
//         deleteModal.show()

//         // Clic on confirm button (modal)
//         document.getElementById('confirmButton').onclick = function() {
//             spinnerContainer.classList.remove('d-none');
//             // DELETE - start             
//             fetch('/admBreeds/delete', {
//                 method: 'DELETE',
//                 headers: {
//                     "Content-Type": "application/json"
//                 },
//                 body: JSON.stringify(id)
//             })
//             .then(response => {
//                 if (!response.ok) {
//                     const toast = new MyToast('Page non disponible', 'danger');
//                     toast.show();
//                 } else {
//                     return response.json();
//                 }
//             })
//             .then(data => {
//                 if (data.success) {
//                     row.remove();
//                     const toast = new MyToast(data.message, 'success');
//                     toast.show();
//                 } 
//                 else {
//                     const toast = new MyToast(`Erreur lors de la suppression des informations sur cette race: ${data.message}`, 'danger');
//                     toast.show();
//                 }
//             })
//             .catch(error => {
//                 const toast = new MyToast(`Erreur lors de la suppression des informations sur cette race: un animal fait partie de cette race, vous devez supprimer les informations de cet animal avent la suppression des informations de la race ou ${error.message}`, 'danger');
//                 toast.show();
//             })
//             .finally(() => {
//                 spinnerContainer.classList.add('d-none');
//             });
//             // DELETE - end
//             deleteModal.hide()
//         }
//     } 
    
//     // UPDATE edition
//     else if (event.target.classList.contains('bi-pencil-square')){
//         const row = event.target.closest('tr');
//         const cells = row.querySelectorAll('td');

//         spinnerContainer.classList.remove('d-none');

//         // original data in variable just in case of cancel
//         row.dataset.originalValues = JSON.stringify(Array.from(cells).slice(0, -1).map(cell => cell.textContent.trim()));

//         // Cells in edition 
//         fetch('/admBreeds/getDiet', {
//             method: 'PUT',
//             headers: {
//                 "Content-Type": "application/json"
//             },
//         })
//         .then(response => {    
//             if (!response.ok) {
//             throw new Error('Des données sont manquantes');
//             }
//             return response.json();
//         })
//         .then(data => {
//             cells.forEach((cell, index) => {
//                 const text = cell.textContent;
            
//                 if (index === 0) {
//                     // input
//                     cell.innerHTML = `<input class="col-12 edit-mode" type="text" value="${text}" />`;
//                 } 
//                 else if (index === 1) {
//                     // select diet
//                     let selectHTML = '<select class="form-select" name="diet">';
//                     data.data.forEach(diet => {
//                         const selected = diet.name === text ? 'selected' : '';
//                         selectHTML += `<option value="${diet.id}" ${selected}>${diet.name}</option>`;
//                     });
//                     selectHTML += '</select>';
//                     cell.innerHTML = selectHTML;
//                 } 
//             });
//         })
//         .catch(error => {
//             console.error('Erreur:', error);
//         })
//         .finally(() => {
//             spinnerContainer.classList.add('d-none');
//         });
      
//         // Hide the other icons
//         const actionCell = cells[cells.length - 1]
//         actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
//             icon.classList.add('hidden');
//         });
//         actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
//             icon.classList.remove('hidden');
//         });
//     } 
//     // UPDATE cancel
//     else if (event.target.classList.contains('bi-x-circle')){
//         const row = event.target.closest('tr');
//         const cells = row.querySelectorAll('td');

//         const originalValues = JSON.parse(row.dataset.originalValues);

//         // Cells view mode
//         cells.forEach((cell, index) => {
//             if (index < cells.length - 1) { // Exclude the last column
//                 cell.textContent = originalValues[index];
//             }
//         });

//         // Hide icons
//         const actionCell = cells[cells.length - 1]
//         actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
//             icon.classList.remove('hidden');
//         });
//         actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
//             icon.classList.add('hidden');
//         });
//     } 
//     // UPDATE !
//     else if (event.target.classList.contains('bi-floppy')) {
//         const row = event.target.closest('tr');
//         const cells = row.querySelectorAll('td');
//         const inputs = row.querySelectorAll('input');
//         const updatedData = Array.from(inputs).map(input => input.value);
//         const serviceId = row.querySelector('.bi-trash').getAttribute('data-id');

//         const dietSelect = row.querySelector('select[name="diet"]');
//         let selectedOption = dietSelect.selectedOptions[0];
//         const selectedDietText = selectedOption.text;
//         const selectedDietId = dietSelect.value;  


//         // Modal show
//         const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier l\'enregistrement de cette race ?', 'Modifier');
//         updateModal.show()

//         // Clic on confirm button (modal)
//         document.getElementById('confirmButton').onclick = function() {
//             spinnerContainer.classList.remove('d-none');
//             const data = {
//                 id: serviceId,
//                 name: updatedData[0],
//                 diet: selectedDietText
//             }
//             // UPDATE - start
//             fetch('/admBreeds/put', {
//                 method: 'PUT',
//                 headers: {
//                     "Content-Type": "application/json"
//                 },
//                 body: JSON.stringify(data)
//             })
//             .then(response => {
//                 if (!response.ok) {
//                     const toast = new MyToast('Page non disponible', 'danger');
//                     toast.show();
//                 } else {
//                     return response.json();
//                 }
//             })
//             .then(data => {
//                 if (data.success) {
//                     cells[0].textContent = updatedData[0];
//                     cells[1].textContent = selectedDietText;
                    
//                     // Hide and show the icons
//                     const actionCell = cells[cells.length - 1];
//                     actionCell.querySelectorAll('.bi-x-circle, .bi-floppy').forEach(icon => {
//                         icon.classList.add('hidden');
//                     });
//                     actionCell.querySelectorAll('.bi-pencil-square, .bi-trash').forEach(icon => {
//                         icon.classList.remove('hidden');
//                     });
//                     const toast = new MyToast(data.message, 'success');
//                     toast.show();
//                 } 
//                 else {
//                     const toast = new MyToast(`Erreur lors de la modification de l'enregistrement : ${data.message}`, 'danger');
//                     toast.show();
//                 }
//             })
//             .catch(error => {
//                 const toast = new MyToast(`Erreur lors de la modification de l'enregistrement : ${error.message}`, 'danger');
//                 toast.show();
//             })
//             .finally(() => {
//                 spinnerContainer.classList.add('d-none');
//             });
//             // UPDATE - end
//             updateModal.hide()
//         }
//     }    
// });

// function addLine(data) {
//     const table = document.getElementById('list-breed').getElementsByTagName('tbody')[0];
//     const newRow = table.insertRow();

//     const nameCell = newRow.insertCell(0);
//     const dietCell = newRow.insertCell(1);
//     const actionsCell = newRow.insertCell(2);
//     nameCell.textContent = data.name;
//     dietCell.textContent = data.diet;

//     actionsCell.className = 'icon-cell';
//     actionsCell.innerHTML = `
//         <i class="bi bi-pencil-square"></i>
//         <i class="bi bi-trash" data-id="${data.id}"></i>
//         <i class="bi bi-x-circle hidden"></i>
//         <i class="bi bi-floppy hidden"></i>
//     `;
// }
