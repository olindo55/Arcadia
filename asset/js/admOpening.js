import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

const spinnerContainer = document.getElementById('spinner-container');
const table = document.getElementById('list-opening');

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    
    const radioButtons = document.querySelectorAll('input[type="radio"]');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Trouver la ligne parent (tr)
            const row = radio.closest('tr');
            // Sélectionner tous les <select> dans cette ligne
            const selects = row.querySelectorAll('select');

            // Si le bouton "Fermé" est sélectionné, désactiver les selects
            if (radio.value === 'closed' && radio.checked) {
                selects.forEach(select => {
                    select.disabled = true;
                });
            } 
            // Si le bouton "Ouvert" est sélectionné, activer les selects
            else if (radio.value === 'open' && radio.checked) {
                selects.forEach(select => {
                    select.disabled = false;
                });
            }
        });
    });
});


// UPDATE
document.getElementById('openingButton').addEventListener('click', function(event){
    event.preventDefault();
        // Modal show
        const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier les horaires ?', 'Modifier');
        updateModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
        
            let data = [];
        
            document.querySelectorAll('#list-opening tbody tr').forEach(row => {
                const rowId = row.getAttribute('data-id');
                // console.log(rowId)
                const openingHour = row.querySelector(`select[name="opening_hour_${rowId}"]`).value;
                const openingMinute = row.querySelector(`select[name="opening_minute_${rowId}"]`).value;
                const closingHour = row.querySelector(`select[name="closing_hour_${rowId}"]`).value;
                const closingMinute = row.querySelector(`select[name="closing_minute_${rowId}"]`).value;
                const radio = row.querySelector(`input[name="opening_${rowId}"][value="closed"]`);
                let closureStatus = false
                if (radio.checked) {
                    closureStatus = true
                }

                data[rowId] = {
                id: rowId,
                opening_hour: openingHour,
                opening_minute: openingMinute,
                closing_hour: closingHour,
                closing_minute: closingMinute,
                closure: closureStatus
                };
            });
            console.log(data);

            // UPDATE - start
            fetch('/admOpening/put', {
                method: 'PUT',
                // body: formData,
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
                const toast = new MyToast(`Erreur lors de la modification des horaires: ${error.message}`, 'danger');
                toast.show();
            })
            .finally(() => {
                spinnerContainer.classList.add('d-none');
            });
            updateModal.hide()
        }
    // }
});



