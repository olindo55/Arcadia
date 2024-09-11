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
            deleteModal.hide()
        }
    }
   
    // UPDATE
    else if (event.target.classList.contains('form-check-input')) {
        const row = event.target.closest('tr');
        const commentId = row.querySelector('.bi-trash').getAttribute('data-id');
        const published = event.target.checked;
        const initialPublishedState = !published;

        // Modal show
        const updateModal = new MyModal(published ? 'Êtes-vous sûr de vouloir publier cet avis ?' : 'Êtes-vous sûr de vouloir retirer de la publication cet avis ?', 'Modifier');
        updateModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');

            const data = {
                id: commentId,
                published: published,
            }
            // UPDATE - start
            fetch('/admComments/put', {
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
                    const toast = new MyToast(data.message, 'success');
                    toast.show();
                } 
                else {
                    const toast = new MyToast(data.message, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la publication de l'avis: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            updateModal.hide()
        }

        // Clic on cancel button (modal)
        document.getElementById('cancelButton').onclick = function() {
            event.target.checked = initialPublishedState;
            updateModal.hide();
        }
        // Clic on cross (modal)
        document.getElementById('modal-close').onclick = function() {
            event.target.checked = initialPublishedState;
            updateModal.hide();
        }
    }
});



