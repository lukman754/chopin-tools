function generateInputs() {
    let num_criteria = document.getElementById('num_criteria').value;
    let num_alternatives = document.getElementById('num_alternatives').value;

    if (!num_criteria || !num_alternatives) {
        alert("Masukkan jumlah kriteria dan alternatif terlebih dahulu.");
        return;
    }

    let criteriaInputs = '<table class="table-responsive w-100"><thead><tr><th>Criteria</th>';
    for (let i = 1; i <= num_criteria; i++) {
        criteriaInputs += '<th>C' + i + '</th>';
    }
    criteriaInputs += '</tr></thead><tbody>';

    // Row for types
    criteriaInputs += '<tr><td><span class="btn border-0 text-right" type="text" name="criteria_type_" class="form-control" value="Type" placeholder="Alternative" readonly disabled></td>';
    for (let j = 0; j < num_criteria; j++) {
        criteriaInputs += `<td><select class="btn btn-inverse-success dropdown-toggle p-2" style="width: 100px;" id="criteria_type_${j}" name="criteria_types[]" required onchange="changeColor(this)">`;
        criteriaInputs += '<option value="benefit" selected>Benefit</option>';
        criteriaInputs += '<option value="cost">Cost</option>';
        criteriaInputs += '</select></td>';
    }
    criteriaInputs += '</tr>';

    // Row for weight
    criteriaInputs += '<tr><td><input class="btn border-0 text text-right" type="text" name="criteria_name_" class="form-control" value="Bobot" placeholder="Alternative" readonly disabled></td>';
    for (let i = 0; i < num_criteria; i++) {
        criteriaInputs += `<td><input type="number" class="btn btn-inverse-info p-2" style="width: 100px;" id="criteria_weight_${i}" name="criteria_weights[]" class="form-control" step="any" value="" required></td>`;
    }
    criteriaInputs += '</tr>';

    // Rows for alternatives
    for (let i = 0; i < num_alternatives; i++) {
        criteriaInputs += '<tr><td><input type="text" name="alternative_names[]" class="form-control" placeholder="Alternative ' + (i + 1) + '" required></td>';
        for (let j = 0; j < num_criteria; j++) {
            criteriaInputs += `<td><input type="number" style="width: 100px;" id="alternative_${i}_criteria_${j}" name="alternatives[${i}][${j}]" class="form-control numeric-input" step="0.01" required></td>`;
        }
        criteriaInputs += '</tr>';
    }

    criteriaInputs += '</tbody></table></div>';

    document.getElementById('criteriaInputs').innerHTML = criteriaInputs;

    loadInputs(); // Load saved inputs
}

function saveInputs() {
    let inputs = document.querySelectorAll('#criteriaInputs input, #criteriaInputs select');
    inputs.forEach(input => {
        localStorage.setItem(input.id, input.value);
    });
}

function loadInputs() {
    let inputs = document.querySelectorAll('#criteriaInputs input, #criteriaInputs select');
    inputs.forEach(input => {
        let savedValue = localStorage.getItem(input.id);
        if (savedValue) {
            input.value = savedValue;
        }
    });
}

function saveInputValues() {
    const numCriteria = document.getElementById('num_criteria').value;
    const numAlternatives = document.getElementById('num_alternatives').value;
    localStorage.setItem('num_criteria', numCriteria);
    localStorage.setItem('num_alternatives', numAlternatives);
}

// Function to load input values from localStorage
function loadInputValues() {
    const numCriteria = localStorage.getItem('num_criteria');
    const numAlternatives = localStorage.getItem('num_alternatives');
    if (numCriteria !== null) {
        document.getElementById('num_criteria').value = numCriteria;
    }
    if (numAlternatives !== null) {
        document.getElementById('num_alternatives').value = numAlternatives;
    }
}

// Load input values on page load
window.onload = function() {
    loadInputValues();
    generateInputsValue(); // Automatically generate inputs on page load
};

// Save input values on input change
window.onbeforeunload = function() {
    saveInputValues();
};

// Function to generate input fields
function generateInputsValue() {
    const numCriteria = document.getElementById('num_criteria').value;
    const numAlternatives = document.getElementById('num_alternatives').value;
    const criteriaContainer = document.getElementById('criteria_container');
    const alternativesContainer = document.getElementById('alternatives_container');

    // Clear previous inputs
    criteriaContainer.innerHTML = '';
    alternativesContainer.innerHTML = '';

    // Generate criteria inputs
    for (let i = 1; i <= numCriteria; i++) {
        const criteriaInput = document.createElement('input');
        criteriaInput.type = 'text';
        criteriaInput.className = 'form-control m-1';
        criteriaInput.placeholder = 'Kriteria ' + i;
        criteriaInput.name = 'criteria_' + i;
        criteriaContainer.appendChild(criteriaInput);
    }

    // Generate alternatives inputs
    for (let i = 1; i <= numAlternatives; i++) {
        const alternativeInput = document.createElement('input');
        alternativeInput.type = 'text';
        alternativeInput.className = 'form-control m-1';
        alternativeInput.placeholder = 'Alternatif ' + i;
        alternativeInput.name = 'alternative_' + i;
        alternativesContainer.appendChild(alternativeInput);
    }
}