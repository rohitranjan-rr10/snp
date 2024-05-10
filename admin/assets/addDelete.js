document.addEventListener("DOMContentLoaded", function() {
    const addButton = document.getElementById("add");
    const deleteButton = document.getElementById("delete");
    const dynamicRows = document.getElementById("dynamicRows");

    addButton.addEventListener("click", function() {
        
        fetch('../includes/fetch_assets.php')
        .then(response => response.text())
        .then(data => {
            const newRow = document.createElement("div");
            newRow.classList.add("row", "g-3");

            newRow.innerHTML = `
                    <div class="col-md-12">
                        <h4></h4>
                    </div>
                    <div class="col-md-12">
                        <label for="desc" class="form-label">Description <span class="required-field">*</span></label>
                        <textarea class="form-control" rows="3" name="desc[]" placeholder="Description" required></textarea>
                    </div>
                    <div class="col-4">
                        <label for="assets" class="form-label">Nature of Asset <span class="required-field">*</span></label>
                        <select class="form-select" name="assets[]" required>
                            ${data}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="qty" class="form-label">Quantity <span class="required-field">*</span></label>
                        <input type="number" class="form-control" name="qty[]" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-5">
                        <label for="grossamt" class="form-label">Gross amount incl. of taxes <span class="required-field">*</span></label>
                        <input type="number" class="form-control" name="grossamt[]" placeholder="Gross amount" step="0.01" required>
                    </div>
                `;

            dynamicRows.appendChild(newRow);
            updateDeleteButtonState();
            
        })
        .catch(error => console.error('Error fetching assets:', error));
    });;

    deleteButton.addEventListener("click", function() {
        const rows = dynamicRows.querySelectorAll(".row.g-3");
        if (rows.length > 1) {
            dynamicRows.removeChild(rows[rows.length - 1]);
        } else {
            alert("At least one row is required.");
        }
        updateDeleteButtonState();
    });

    function updateDeleteButtonState() {
        const rows = dynamicRows.querySelectorAll(".row.g-3");
        if (rows.length === 1) {
            deleteButton.disabled = true;
        } else {
            deleteButton.disabled = false;
        }
    }

    updateDeleteButtonState();
});
