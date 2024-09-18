import TableSort from './class/TableSort.js';
import MyModal from './class/MyModal.js';
import MyToast from './class/MyToast.js';

const spinnerContainer = document.getElementById('spinner-container');

const table = document.getElementById('list-animal');

let tableSorter;

document.addEventListener('DOMContentLoaded', () => {
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    
    // Sort
    tableSorter = new TableSort(table);
    const headers = table.querySelectorAll('thead th');
    headers[0].addEventListener('click', () => {
        tableSorter.sortColumn(0, 'sort-icon-name');
    });
    headers[1].addEventListener('click', () => {
        tableSorter.sortColumn(1, 'sort-icon-breed');
    });
    headers[2].addEventListener('click', () => {
        tableSorter.sortColumn(2, 'sort-icon-biome');
    });
});


// POST
document.getElementById('addBiomeButton').addEventListener('click', function(event){
    event.preventDefault();
    spinnerContainer.classList.remove('d-none');

    const form = document.getElementById('admForm');
    const formData = new FormData(form);

    fetch('/admAnimals/post', {
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
        const toast = new MyToast(`Erreur lors de  l'ajout de l'animal: ${error.message}`, 'danger');
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
        const deleteModal = new MyModal('Êtes-vous sûr de vouloir supprimer les informations concernant cet animal ?', 'Supprimer');
        deleteModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            // DELETE - start             
            fetch('/admAnimals/delete', {
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
                    const toast = new MyToast(`Erreur lors de la suppression des informations sur cet animal: ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la suppression des informations sur cet animal: ${error.message}`, 'danger');
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

        spinnerContainer.classList.remove('d-none');

        // original data in variable just in case of cancel
        row.dataset.originalValues = JSON.stringify(Array.from(cells).slice(0, -1).map(cell => cell.textContent.trim()));

        // Cells in edition 
        fetch('/admAnimals/getBreedBiome', {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json"
            },
        })
        .then(response => {    
            if (!response.ok) {
            throw new Error('Les données des races ou des habitats sont manquantes');
            }
            return response.json();
        })
        .then(responseData => {
            const data = responseData.data;
            cells.forEach((cell, index) => {
                const text = cell.textContent;
            
                if (index === 0 || index === 3 || index === 4) {
                    // input
                    cell.innerHTML = `<input class="col-12 edit-mode" type="text" value="${text}" />`;
                } 
                else if (index === 1) {
                    // select breed
                    let selectHTML = '<select class="form-select" name="breed">';
                    data.breeds.forEach(breed => {
                        const selected = breed.name === text ? 'selected' : '';
                        selectHTML += `<option value="${breed.id}" ${selected}>${breed.name}</option>`;
                    });
                    selectHTML += '</select>';
                    cell.innerHTML = selectHTML;
                } 
                else  if (index === 2){
                    // select biome
                    let selectHTML = '<select class="form-select" name="biome">';
                    data.biomes.forEach(biome => {
                        const selected = biome.name === text ? 'selected' : '';
                        selectHTML += `<option value="${biome.id}" ${selected}>${biome.name}</option>`;
                    });
                    selectHTML += '</select>';
                    cell.innerHTML = selectHTML;
                }
            });
        })
        .catch(error => {
            console.error('Erreur:', error);
        })
        .finally(() => {
            spinnerContainer.classList.add('d-none');
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

        // Hide icons
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

        const breedSelect = row.querySelector('select[name="breed"]');
        let selectedOption = breedSelect.selectedOptions[0]; // Récupère la première option sélectionnée
        // const selectedBreedId = selectedOption.value; // Récupère la valeur de l'option sélectionnée
        const selectedBreedText = selectedOption.text;
        const selectedBreedId = breedSelect.value;  
        // const selectedBreedText = breedSelect.text;
        const biomeSelect = row.querySelector('select[name="biome"]'); 
        selectedOption = biomeSelect.selectedOptions[0]; // Récupère la première option sélectionnée
        // const selectedBiomeId = selectedOption.value; // Récupère la valeur de l'option sélectionnée
        const selectedBiomeText = selectedOption.text; 
        const selectedBiomeId = biomeSelect.value;
        // const selectedBiomeText = biomeSelect.text;

        // Modal show
        const updateModal = new MyModal('Êtes-vous sûr de vouloir modifier l\'enregistrement de cet animal ?', 'Modifier');
        updateModal.show()

        // Clic on confirm button (modal)
        document.getElementById('confirmButton').onclick = function() {
            spinnerContainer.classList.remove('d-none');
            const data = {
                id: serviceId,
                name: updatedData[0],
                breed: selectedBreedId,
                biome: selectedBiomeId,
                image_url: updatedData[1],
                image_alt: updatedData[2]
            }
            // UPDATE - start
            fetch('/admAnimals/put', {
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
                    // inputs.forEach((input, index) => {
                    //     cells[index].textContent = input.value;
                    // });
                    
                    cells[0].textContent = updatedData[0];
                    cells[1].textContent = selectedBreedText;
                    cells[2].textContent = selectedBiomeText;
                    cells[3].textContent = updatedData[1];
                    cells[4].textContent = updatedData[2];
                    
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
                    const toast = new MyToast(`Erreur lors de la modification de l'enregistrement : ${data.message}`, 'danger');
                    toast.show();
                }
            })
            .catch(error => {
                const toast = new MyToast(`Erreur lors de la modification de l'enregistrement : ${error.message}`, 'danger');
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
    const table = document.getElementById('list-animal').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    const nameCell = newRow.insertCell(0);
    const breedCell = newRow.insertCell(1);
    const biomeCell = newRow.insertCell(2);
    const imageUrlCell = newRow.insertCell(3);
    const altCell = newRow.insertCell(4);
    const actionsCell = newRow.insertCell(5);

    nameCell.textContent = data.name;
    breedCell.textContent = data.breed;
    biomeCell.textContent = data.biome;
    imageUrlCell.textContent = data.upload;
    altCell.textContent = data.alt;

    actionsCell.className = 'icon-cell';
    actionsCell.innerHTML = `
        <i class="bi bi-pencil-square"></i>
        <i class="bi bi-trash" data-id="${data.id}"></i>
        <i class="bi bi-x-circle hidden"></i>
        <i class="bi bi-floppy hidden"></i>
    `;
}
