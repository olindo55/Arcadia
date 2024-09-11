export default class TableSort {

    constructor(table) {
        this.table = table;
    }

    isNumeric(value) {
        return !isNaN(value) && !isNaN(parseFloat(value));
    }

    isCheckboxColumn(columnIndex) {
        const firstRow = this.table.tBodies[0].rows[0];
        const cell = firstRow.cells[columnIndex];
        return cell.querySelector('input[type="checkbox"]') !== null;
    }

    isSelectColumn(columnIndex) {
        const firstRow = this.table.tBodies[0].rows[0];
        const cell = firstRow.cells[columnIndex];
        return cell.querySelector('select') !== null;
    }

    sortColumn(columnIndex, iconId) {
        const tbody = this.table.tBodies[0];
        const rows = Array.from(tbody.rows);

        const icon = document.getElementById(iconId);
        let ascending = icon.classList.contains('bi-sort-down');

        const firstCell = rows[0].cells[columnIndex].textContent.trim().toLowerCase();
        let dataType = 'string';

        if (this.isNumeric(firstCell)) {
            dataType = 'number';
        } else if (this.isCheckboxColumn(columnIndex)) {
            dataType = 'checkbox';
        } else if (this.isSelectColumn(columnIndex)) {
            dataType = 'select';
        }

        rows.sort((a, b) => {
            let cellA, cellB;

            if (dataType === 'select') {
                cellA = a.cells[columnIndex].querySelector('select').selectedOptions[0].textContent.toLowerCase();
                cellB = b.cells[columnIndex].querySelector('select').selectedOptions[0].textContent.toLowerCase();
            } else {
                cellA = a.cells[columnIndex].textContent.trim().toLowerCase();
                cellB = b.cells[columnIndex].textContent.trim().toLowerCase();
            }

            if (dataType === 'number') {
                const numA = parseFloat(cellA);
                const numB = parseFloat(cellB);
                return ascending ? numA - numB : numB - numA;
            } else if (dataType === 'checkbox') {
                const checkboxA = a.cells[columnIndex].querySelector('input[type="checkbox"]').checked;
                const checkboxB = b.cells[columnIndex].querySelector('input[type="checkbox"]').checked;
                if (ascending) {
                    return checkboxA === checkboxB ? 0 : checkboxA ? 1 : -1;
                } else {
                    return checkboxA === checkboxB ? 0 : checkboxA ? -1 : 1;
                }
            } else if (dataType === 'select') {
                return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            } else {
                return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
            }
        });

        rows.forEach(row => tbody.appendChild(row));

        if (ascending) {
            icon.classList.remove('bi-sort-down');
            icon.classList.add('bi-sort-down-alt');
        } else {
            icon.classList.remove('bi-sort-down-alt');
            icon.classList.add('bi-sort-down');
        }
    }
}
