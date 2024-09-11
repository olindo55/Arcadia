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
    const table = document.getElementById('list-user');
    tableSorter = new TableSort(table);

    const headers = table.querySelectorAll('thead th');

    headers[0].addEventListener('click', () => {
        tableSorter.sortColumn(0, 'sort-icon-id');
    });
    headers[1].addEventListener('click', () => {
        tableSorter.sortColumn(1, 'sort-icon-name');
    });
    headers[2].addEventListener('click', () => {
        tableSorter.sortColumn(2, 'sort-icon-forname');
    });
    headers[3].addEventListener('click', () => {
        tableSorter.sortColumn(3, 'sort-icon-email');
    });
    headers[4].addEventListener('click', () => {
        tableSorter.sortColumn(4, 'sort-icon-role');
    });
});


const table = document.getElementById('list-user');
table.addEventListener('click', function(event) {

    // DELETE
    if (event.target.classList.contains('bi-trash')) {
        const id = {
            id: event.target.getAttribute('data-id')
        };
        const row = event.target.closest('tr');

        // Modal show
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer cet utilisateur ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');

            fetch('/admUsers/delete', {
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
                    const toast = new MyToast(`Erreur lors de la suppression de l'utilisateur: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la suppression de l'utilisateur: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            deleteModal.hide()
        }
    }
});
    // UPDATE
    let initialRole;

    document.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('list-user');

        table.addEventListener('focus', function(event) {
            if (event.target.classList.contains('form-select')) {
                const selectElement = event.target;
                initialRole = selectElement.value;
            }
        }, true);
    
        table.addEventListener('change', function(event) {
            if (event.target.classList.contains('form-select')) {
                const selectElement = event.target;
                const row = event.target.closest('tr');
                const userId = row.querySelector('.bi-trash').getAttribute('data-id');
    
                // Modal show
                const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier les droits de cet utilisateur ?', 'Modifier');
                updateModal.show();
    
                document.getElementById('confirmButton').onclick = function() {
                    spinnerContainer.classList.remove('d-none');
                    const newRole = selectElement.value;
                    const data = {
                        id: userId,
                        role: newRole,
                    }
                    fetch('/admUsers/put', {
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
                        const toast = new MyToast(`Erreur lors de la modification des droits: ${error.message}`, 'danger');
                        toast.show();
                    })
                    .finally(() => {
                        spinnerContainer.classList.add('d-none');
                    });
                    updateModal.hide()
                }
                document.getElementById('cancelButton').onclick = function() {
                    selectElement.value = initialRole;  
                    updateModal.hide();
                }
                document.getElementById('modal-close').onclick = function() {
                    event.target.value = initialRole;  
                }
            }
        });
    });
