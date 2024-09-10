import Comment from './class/Comment.js';
import TableSort from './class/TableSort.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

// let comments = [];

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
});
const spinnerContainer = document.getElementById('spinner-container');


// Sort the column
let tableSorter;

document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('list-comment');
    tableSorter = new TableSort(table);

    const headers = table.querySelectorAll('thead th');

    headers[0].addEventListener('click', () => {
        tableSorter.sortColumn(0, 'sort-icon-id');
    });
    headers[1].addEventListener('click', () => {
        tableSorter.sortColumn(1, 'sort-icon-published');
    });
    headers[2].addEventListener('click', () => {
        tableSorter.sortColumn(2, 'sort-icon-pseudo');
    });
    headers[4].addEventListener('click', () => {
        tableSorter.sortColumn(4, 'sort-icon-score');
    });
    headers[5].addEventListener('click', () => {
        tableSorter.sortColumn(5, 'sort-icon-date');
    });
    headers[6].addEventListener('click', () => {
        tableSorter.sortColumn(6, 'sort-icon-approver');
    });
});


const table = document.getElementById('list-comment');
table.addEventListener('click', function(event) {
    // DELETE
    if (event.target.classList.contains('bi-trash')) {
        const id = {
            id: event.target.getAttribute('data-id')
        };
        const row = event.target.closest('tr');

        // Modal show
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer cet avis ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            // DELETE - start             
            fetch('/admComments/delete', {
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
                    const toast = new MyToast(`Erreur lors de la suppression de l'avis: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la suppression de l'avis: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            // DELETE - end
            deleteModal.hide()
        }
    }
});
    
//     // UPDATE edition
//     else if (event.target.classList.contains('bi-pencil-square')){
//         const row = event.target.closest('tr');
//         const cells = row.querySelectorAll('td');

//         // original data in var just in case of cancel
//         row.dataset.originalValues = JSON.stringify(Array.from(cells).slice(0, -1).map(cell => cell.textContent.trim()));

//         // Cells in edition mode
//         cells.forEach((cell, index) => {
//             if (index < cells.length - 1) { // Exclude the last columne
//                 const text = cell.textContent;
//                 cell.innerHTML = `<input class=" col-12 edit-mode" type="text" value="${text}" />`;
//             }
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

//         // Hide icoons
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

//         // Modal show
//         const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier ce service ?', 'Modifier');
//         updateModal.show()

//         // Clic on confirm button (modal)
//         document.getElementById('confirmButton').onclick = function() {
//             spinnerContainer.classList.remove('d-none');
//             const data = {
//                 id: serviceId,
//                 name: updatedData[0],
//                 description: updatedData[1],
//                 image_url: updatedData[2],
//                 image_alt: updatedData[3]
//             }
//             // UPDATE - start
//             fetch('/admServices/put', {
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
//                     // Update the cells with the new datas
//                     inputs.forEach((input, index) => {
//                         cells[index].textContent = input.value;
//                     });
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
//                     const toast = new MyToast(`Erreur lors de la modification du service: ${data.message}`, 'danger');
//                     toast.show();
//                 }
//             })
//             .catch(error => {
//                 const toast = new MyToast(`Erreur lors de la modification du service: ${error.message}`, 'danger');
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



