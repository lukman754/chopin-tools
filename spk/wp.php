<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chopin Tools</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- End layout styles -->
    <link rel="icon" href="../assets/images/logo-mini.svg">
</head>

<?php include "../db.php"; ?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo w-100" href="index.php"><img src="../assets/images/logo.svg" class="img w-100" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.php"><img src="../assets/images/logo-mini.svg" class="img w-100 pr-4" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item nav-category">
                    <span class="nav-link">Tools</span>
                </li>
                <?php foreach ($method as $row) { ?>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="<?php echo $row['link']; ?>">
                            <span class="menu-icon">
                                <i class="mdi mdi-scale-balance"></i>
                            </span>
                            <span class="menu-title"><?php echo $row['name']; ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100">
                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">

                            </form>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card corona-gradient-card">
                                <div class="card-body py-0 px-0 px-sm-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-sm-3 col-xl-2">
                                            <i class="mdi mdi-relative-scale text pl-5" style="font-size: 40px;"></i>
                                        </div>
                                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                                            <h4 class="mb-1 mb-sm-0">Weightning Product (WP)</h4>
                                            <p class="mb-0 font-weight-normal d-none d-sm-block">Pendekatan untuk pengambilan keputusan yang menggunakan perkalian antara nilai kriteria dengan bobot relatifnya.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Function to save input values to localStorage
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
                            generateInputs(); // Automatically generate inputs on page load
                        };

                        // Save input values on input change
                        window.onbeforeunload = function() {
                            saveInputValues();
                        };

                        // Function to generate input fields
                        function generateInputs() {
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
                    </script>
                    <form method="post">
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Input Kriteria dan Alternatif</h4>
                                        <div class="form-group row">
                                            <div class="col">
                                                <label>Kriteria</label>
                                                <div id="the-basics">
                                                    <input class="typeahead" type="number" id="num_criteria" name="num_criteria" value="<?php echo isset($_POST['num_criteria']) ? $_POST['num_criteria'] : '3'; ?>" min="1" max="100" required placeholder="Masukkan jumlah Kriteria">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Alternatif</label>
                                                <div id="bloodhound">
                                                    <input class="typeahead" type="number" id="num_alternatives" name="num_alternatives" value="<?php echo isset($_POST['num_alternatives']) ? $_POST['num_alternatives'] : '2'; ?>" min="2" max="100" required placeholder="Masukkan jumlah Alternatif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-inverse-primary btn-fw w-50 m-1" onclick="generateInputs()">Generate Inputs</button>
                                        <button type="button" class="btn btn-inverse-danger btn-fw w-50 m-1" onclick="resetForm()">Reset Form</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Dynamic Criteria Form</h4>
                                        <div id="criteriaInputs">
                                            <!-- Criteria table will be generated here -->
                                        </div>
                                    </div>
                                    <button type="submit" id="hitungButton" class="btn btn-inverse-success btn-fw m-1">Hitung</button>
                                </div>
                            </div>
                    </form>

                    <script>
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
                            criteriaInputs += '<tr><td><input class="btn border-0 text-right" type="text" name="criteria_type_" class="form-control" value="Type" placeholder="Alternative" readonly disabled></td>';
                            for (let j = 0; j < num_criteria; j++) {
                                criteriaInputs += `<td><select class="btn btn-inverse-success dropdown-toggle p-2" style="width: 100px;" id="criteria_type_${j}" name="criteria_types[]" required onchange="changeColor(this)">`;
                                criteriaInputs += '<option value="benefit">Benefit</option>';
                                criteriaInputs += '<option value="cost">Cost</option>';
                                criteriaInputs += '</select></td>';
                            }
                            criteriaInputs += '</tr>';

                            // Row for weight
                            criteriaInputs += '<tr><td><input class="btn border-0 text text-right" type="text" name="criteria_name_" class="form-control" value="Bobot" placeholder="Alternative" readonly disabled></td>';
                            for (let i = 0; i < num_criteria; i++) {
                                criteriaInputs += `<td><input type="number" class="btn btn-inverse-info p-2" style="width: 100px;" id="criteria_weight_${i}" name="criteria_weights[]" class="form-control" step="any" required></td>`;
                            }
                            criteriaInputs += '</tr>';

                            // Rows for alternatives
                            for (let i = 0; i < num_alternatives; i++) {
                                criteriaInputs += `<tr><td><input type="text" id="alternative_name_${i}" name="alternative_names[]" class="form-control" placeholder="Alternative ${i + 1}" required></td>`;
                                for (let j = 0; j < num_criteria; j++) {
                                    criteriaInputs += `<td><input type="number" style="width: 100px;" id="alternative_${i}_criteria_${j}" name="alternatives[${i}][${j}]" class="form-control numeric-input" step="0.01" required></td>`;
                                }
                                criteriaInputs += '</tr>';
                            }

                            criteriaInputs += '</tbody></table></div>';

                            document.getElementById('criteriaInputs').innerHTML = criteriaInputs;

                            // Restore previous values if they exist
                            <?php if (!empty($_POST['criteria_types'])) : ?>
                                <?php foreach ($_POST['criteria_types'] as $key => $value) : ?>
                                    document.getElementById('criteria_type_<?php echo $key; ?>').value = '<?php echo $value; ?>';
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($_POST['criteria_weights'])) : ?>
                                <?php foreach ($_POST['criteria_weights'] as $key => $value) : ?>
                                    document.getElementById('criteria_weight_<?php echo $key; ?>').value = '<?php echo $value; ?>';
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($_POST['alternative_names'])) : ?>
                                <?php foreach ($_POST['alternative_names'] as $key => $value) : ?>
                                    document.getElementById('alternative_name_<?php echo $key; ?>').value = '<?php echo $value; ?>';
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if (!empty($_POST['alternatives'])) : ?>
                                <?php foreach ($_POST['alternatives'] as $i => $row) : ?>
                                    <?php foreach ($row as $j => $value) : ?>
                                        document.getElementById('alternative_<?php echo $i; ?>_criteria_<?php echo $j; ?>').value = '<?php echo $value; ?>';
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        }

                        // Call generateInputs() when the page loads
                        document.addEventListener('DOMContentLoaded', generateInputs);
                    </script>
                    <script>
                        // Function to change color based on selection
                        function changeColor(selectElement) {
                            if (selectElement.value === "cost") {
                                selectElement.classList.remove('btn-inverse-success');
                                selectElement.classList.add('btn-inverse-warning');
                            } else {
                                selectElement.classList.remove('btn-inverse-warning');
                                selectElement.classList.add('btn-inverse-success');
                            }
                        }
                    </script>

                    <script>
                        function resetForm() {
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
                            criteriaInputs += '<tr><td><input class="btn border-0 text-right" type="text" name="criteria_type_" class="form-control" value="Type" placeholder="Alternative" readonly disabled></td>';
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
                        }
                    </script>
                </div>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $num_criteria = $_POST['num_criteria'];
                    $num_alternatives = $_POST['num_alternatives'];
                    $criteria_types = $_POST['criteria_types'];
                    $criteria_weights = $_POST['criteria_weights'];
                    $alternatives = $_POST['alternatives'];
                    $alternative_names = $_POST['alternative_names'];

                    $errors = [];

                    for ($i = 0; $i < $num_criteria; $i++) {
                        if (!in_array($criteria_types[$i], ['benefit', 'cost'])) {
                            $errors[] = "Tipe kriteria harus 'benefit' atau 'cost'";
                        }
                        if ($criteria_weights[$i] <= 0) {
                            $errors[] = "Bobot kriteria harus lebih besar dari 0";
                        }
                    }

                    for ($i = 0; $i < $num_alternatives; $i++) {
                        if (empty($alternative_names[$i])) {
                            $errors[] = "Nama alternatif tidak boleh kosong";
                        }
                        for ($j = 0; $j < $num_criteria; $j++) {
                            if ($alternatives[$i][$j] <= 0) {
                                $errors[] = "Nilai kriteria untuk alternatif " . ($i + 1) . " harus lebih besar dari 0";
                                break;
                            }
                        }
                    }

                    if (empty($errors)) {
                        $total_weight = array_sum($criteria_weights);
                        $normalized_weights = array_map(function ($weight) use ($total_weight) {
                            return $weight / $total_weight;
                        }, $criteria_weights);

                        foreach ($criteria_types as $index => $type) {
                            if ($type == 'cost') {
                                $normalized_weights[$index] = -$normalized_weights[$index];
                            }
                        }

                        $normalized_weights = array_map(function ($weight) {
                            return round($weight, 2);
                        }, $normalized_weights);

                        $results = [];
                        foreach ($alternatives as $i => $row) {
                            $result = 1;
                            foreach ($row as $j => $value) {
                                $weight = $normalized_weights[$j];
                                $result *= $value ** $weight;
                            }
                            $results[] = $result;
                        }

                        $total_result = array_sum($results);
                        $rankings = array_map(function ($result) use ($total_result) {
                            return $result / $total_result;
                        }, $results);
                    }
                }
                ?>



                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) : ?>
                                    <h4>Data</h4>
                                    <div class="table-responsive w-100 mb-4">
                                        <table class="table">
                                            <tr class="table btn-inverse-warning">
                                                <th>Kriteria/Alternatif</th>
                                                <?php for ($i = 0; $i < $num_criteria; $i++) : ?>
                                                    <th>C<?= ($i + 1) ?></th>
                                                <?php endfor; ?>
                                            </tr>

                                            <tbody class="text-light">
                                                <?php foreach ($alternatives as $i => $row) : ?>
                                                    <tr>
                                                        <td class="table-dark text-light"><?= htmlspecialchars($alternative_names[$i]) ?></td>
                                                        <?php foreach ($row as $value) : ?>
                                                            <td><?= htmlspecialchars($value) ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h4>Perhitungan Bobot</h4>
                                    <div class="table-responsive w-100 mb-4">
                                        <table class="table">
                                            <tbody>
                                                <tr class="table btn-inverse-info">
                                                    <td class="text-light">Weights :</td>
                                                    <td>
                                                        <?php
                                                        $counter = 1;
                                                        foreach ($criteria_weights as $weight) {
                                                            echo "<span style='font-size: 9px;'>C" . $counter . "</span><span class='text-warning'>" . $weight . "</span>";
                                                            if ($counter < count($criteria_weights)) {
                                                                echo "&nbsp; &nbsp;";
                                                            }
                                                            $counter++;
                                                        }
                                                        ?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="table-dark text-light">Total Weight</td>
                                                    <td><span class='text-info'><?= $total_weight ?></span></td>
                                                </tr>
                                                <?php foreach ($criteria_weights as $i => $weight) : ?>
                                                    <tr>
                                                        <?php
                                                        $class = ($criteria_types[$i] === 'benefit') ? 'text-success' : 'text-danger';
                                                        ?>
                                                        <td class="table-dark text-light">W<?= ($i + 1) ?> <span class="<?= $class ?>">(<?= $criteria_types[$i] ?>)</span></td>
                                                        <td><span class='text-warning'><?= $weight ?></span> / <span class='text-info'><?= $total_weight ?></span> = <span class="<?= $class ?>"><?= $normalized_weights[$i] ?></span></td>

                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr class="table btn-inverse-info">
                                                    <td class="text-light">Normalized Weights :</td>
                                                    <td>
                                                        <?php
                                                        $counter = 1;
                                                        foreach ($normalized_weights as $weight) : ?>
                                                            <span style='font-size: 9px;'>C<?= $counter ?></span>
                                                            <span class='text-warning'><?= $weight ?></span>&nbsp;&nbsp;
                                                        <?php
                                                            $counter++;
                                                        endforeach; ?>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <h4>Perhitungan Hasil</h4>
                                    <p class="text-muted small" style="line-height: 0.5;">*Klik tombol dibawah ini untuk melihat cara perhitungan</p>

                                    <h4><a data-toggle="collapse" href="#collapseCalculation" aria-expanded="false" aria-controls="collapseCalculation" class="btn btn-inverse-info w-100">Calculation</a></h4>
                                    <div class="table-responsive w-100 mb-4">
                                        <table class="table">

                                            <?php
                                            // Calculate results for each alternative
                                            $results = [];
                                            $calculation_strings = [];
                                            foreach ($alternatives as $i => $row) {
                                                $calculation_steps = [];
                                                $result = 1;
                                                foreach ($row as $j => $value) {
                                                    $weight = $normalized_weights[$j];
                                                    $class = ($criteria_types[$j] == 'cost') ? 'text-danger' : 'text-success'; // Determine class based on criteria type
                                                    $calc = $value ** $weight;
                                                    // Apply the appropriate class to the $weight value and add 'small' and top alignment
                                                    $calculation_steps[] = "($value<span class='$class small align-top'>^$weight</span>)";
                                                    $result *= $calc;
                                                }
                                                $calculation_str = implode(" * ", $calculation_steps);
                                                $results[] = [
                                                    'name' => $alternative_names[$i],
                                                    'calculation' => $calculation_str,
                                                    'result' => number_format($result, 4)
                                                ];
                                            }
                                            ?>



                                            <tbody>
                                                <tr class="table btn-inverse-info">
                                                    <th>Alternative</th>
                                                    <div id="collapseCalculation" class="collapse">
                                                        <?php echo "<th></th>" ?>
                                                    </div>
                                                    <th>Hasil</th>
                                                </tr>
                                                <?php foreach ($results as $result) : ?>
                                                    <tr>
                                                        <td class="text-light table-dark"><?php echo htmlspecialchars($result['name']); ?></td>
                                                        <td class="text-light table-dark">
                                                            <div id="collapseCalculation" class="collapse">
                                                                <?php echo $result['calculation']; ?> &nbsp; =
                                                            </div>

                                                        </td>
                                                        <td class="text-light table-dark"><?php echo $result['result']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                        </table>

                                    </div>
                                    <style>
                                        .sortable::after {
                                            content: '\f0dc';
                                            /* Default icon (unsorted) */
                                            font-family: 'Font Awesome 5 Free';
                                            font-weight: 900;
                                            margin-left: 10px;
                                        }

                                        .sortable.asc::after {
                                            content: '\f0de';
                                            /* Up arrow */
                                        }

                                        .sortable.desc::after {
                                            content: '\f0dd';
                                            /* Down arrow */
                                        }
                                    </style>
                                    <h4>Perankingan</h4>
                                    <p class="text-muted small" style="line-height: 0.5;">*Klik tombol dibawah ini untuk melihat cara perhitungan</p>
                                    <h4><a data-toggle="collapse" href="#collapseRanking" aria-expanded="false" aria-controls="collapseRanking" class="btn btn-inverse-warning w-100">Calculation</a></h4>
                                    <div class="mb-2">
                                        <input type="text" id="search-input" class="form-control" placeholder="Cari Nama">
                                    </div>
                                    <div class="table-responsive w-100">
                                        <?php
                                        $total = array_sum(array_column($results, 'result')); // Calculate the total for ranking
                                        $maxResult = max(array_column($results, 'result'));
                                        $rank = 2; // Start ranking from 2 for non-highest values

                                        $rankedResults = []; // Array to store ranked results

                                        foreach ($results as $i => $result) {
                                            $ranking = $result['result'] / $total;
                                            $isMax = $result['result'] === $maxResult; // Check if this is the highest value

                                            $rankedResults[] = [
                                                'name' => $result['name'],
                                                'ranking' => $ranking,
                                                'isMax' => $isMax
                                            ];
                                        }
                                        ?>
                                        <table class="table">
                                            <thead class="table position-sticky" style="top: 0; background-color: #191c24; z-index: 1000;">
                                                <tr class="table btn-inverse-warning">
                                                    <th class="text-light">Alternative</th>
                                                    <th></th>
                                                    <th id="nilai-header" class="sortable text-light" style="cursor: pointer;">Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <?php foreach ($rankedResults as $i => $result) : ?>
                                                    <tr>
                                                        <td class="<?= $result['isMax'] ? 'text-warning' : '' ?> table-dark">
                                                            <span class="text-muted small">A<?= ($i + 1) . ". </span> " . htmlspecialchars($result['name']); ?>
                                                                <?php if ($result['isMax']) : ?>
                                                                    <span>👑</span>
                                                                <?php endif; ?>
                                                        </td>
                                                        <td class="<?= $result['isMax'] ? 'text-warning' : '' ?> table-dark">
                                                            <div id="collapseRanking" class="collapse">
                                                                <?= $results[$i]['result'] ?> / (<?= implode(" + ", array_column($results, 'result')) ?>) &nbsp; =
                                                            </div>
                                                        </td>
                                                        <td class="<?= $result['isMax'] ? 'text-warning' : '' ?> table-dark"><?= number_format($result['ranking'], 4) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <canvas id="barChart" width="400" height="200"></canvas>

                                        <script>
                                            const rankedResults = <?= json_encode($rankedResults) ?>;
                                            const alternatives = rankedResults.map(result => result.name);
                                            const rankings = rankedResults.map(result => result.ranking);
                                            const maxRanking = Math.max(...rankings);
                                            const minRanking = Math.min(...rankings);

                                            const labels = alternatives.map((_, index) => `A${index + 1}`);

                                            const data = {
                                                labels: labels,
                                                datasets: [{
                                                    label: 'Ranking',
                                                    data: rankings,
                                                    backgroundColor: rankings.map(ranking => {
                                                        if (ranking === maxRanking) return 'rgba(47, 178, 67, 0.2)'; // Green for max
                                                        if (ranking === minRanking) return 'rgba(255, 99, 132, 0.2)'; // Red for min
                                                        return 'rgba(234, 163, 32, 0.2)'; // Grey for others
                                                    }),
                                                    borderColor: rankings.map(ranking => {
                                                        if (ranking === maxRanking) return 'rgba(47, 178, 67, 1)'; // Green for max
                                                        if (ranking === minRanking) return 'rgba(255, 99, 132, 1)'; // Red for min
                                                        return 'rgba(234, 163, 32, 1)'; // Grey for others
                                                    }),
                                                    borderWidth: 1,
                                                    fill: false
                                                }]
                                            };

                                            const options = {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            };

                                            if (document.getElementById('barChart')) {
                                                var barChartCanvas = document.getElementById('barChart').getContext('2d');
                                                var barChart = new Chart(barChartCanvas, {
                                                    type: 'bar',
                                                    data: data,
                                                    options: options
                                                });
                                            }
                                        </script>



                                        <script>
                                            document.addEventListener('DOMContentLoaded', () => {
                                                const tableBody = document.getElementById('table-body');
                                                const nilaiHeader = document.getElementById('nilai-header');
                                                const searchInput = document.getElementById('search-input');
                                                let sortDirection = false;

                                                nilaiHeader.addEventListener('click', () => {
                                                    sortTable();
                                                });

                                                searchInput.addEventListener('input', () => {
                                                    filterTable();
                                                });

                                                function sortTable() {
                                                    let rows = Array.from(tableBody.querySelectorAll('tr'));
                                                    rows.sort((a, b) => {
                                                        let aValue = parseFloat(a.cells[2].innerText);
                                                        let bValue = parseFloat(b.cells[2].innerText);
                                                        return sortDirection ? aValue - bValue : bValue - aValue;
                                                    });

                                                    sortDirection = !sortDirection;
                                                    nilaiHeader.classList.toggle('asc', sortDirection);
                                                    nilaiHeader.classList.toggle('desc', !sortDirection);

                                                    rows.forEach(row => tableBody.appendChild(row));
                                                }

                                                function filterTable() {
                                                    let filter = searchInput.value.toLowerCase();
                                                    let rows = tableBody.querySelectorAll('tr');
                                                    rows.forEach(row => {
                                                        let alternative = row.cells[0].innerText.toLowerCase();
                                                        if (alternative.includes(filter)) {
                                                            row.style.display = '';
                                                        } else {
                                                            row.style.display = 'none';
                                                        }
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-flex flex-column align-items-center">

                    <div class="social-icons text-center">
                        <a href="https://facebook.com/lukman.mauludin.754" target="_blank" class="mx-3">
                            <i class="fab fa-facebook-f" style="font-size: 24px;"></i>
                        </a>
                        <a href="https://instagram.com/_.chopin" target="_blank" class="mx-3">
                            <i class="fab fa-instagram" style="font-size: 24px;"></i>
                        </a>
                        <a href="https://github.com/Lukman754
            " target="_blank" class="mx-3">
                            <i class="fab fa-github" style="font-size: 24px;"></i>
                        </a>
                    </div>
                    <span class="text-muted text-center mt-2">
                        Copyright &copy; Lukman Muludin <?php echo date('Y'); ?>
                    </span>
                </div>
            </footer>


            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>

    <!-- End custom js for this page -->
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>