function searchTable() {
    const table = document.querySelector(".table");
    const tbody = table.querySelector("tbody");

    let filter = document.querySelector('[name="search"]').value.toLowerCase();
    let rows = tbody.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let matchFound = false;

        for (let j = 0; j < cells.length; j++) {
            let cell = cells[j];
            if (cell && cell.textContent.toLowerCase().indexOf(filter) > -1) {
                matchFound = true;
                break;
            }
        }

        matchFound
            ? rows[i].classList.remove("d-none")
            : rows[i].classList.add("d-none");
    }
}
