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
        <a class="sidebar-brand brand-logo w-100" href="index.php"><img src="assets/images/logo.svg" class="img w-100" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg" class="img w-100 pr-4" alt="logo" /></a>
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
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
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
                      <i class="mdi mdi-scale-balance text pl-5" style="font-size: 40px;"></i>
                    </div>
                    <div class="col-5 col-sm-7 col-xl-8 p-0">
                      <h4 class="mb-1 mb-sm-0">Simple Additive Weighting (SAW)</h4>
                      <p class="mb-0 font-weight-normal d-none d-sm-block">mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif di semua atribut.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          // Inisialisasi variabel
          $num_criteria = isset($_POST['num_criteria']) ? (int)$_POST['num_criteria'] : 4;
          $num_alternatives = isset($_POST['num_alternatives']) ? (int)$_POST['num_alternatives'] : 2;
          $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : [];
          $types = isset($_POST['types']) ? $_POST['types'] : [];
          $weights = isset($_POST['weights']) ? $_POST['weights'] : [];
          $alternative_names = isset($_POST['alternative_names']) ? $_POST['alternative_names'] : [];

          // Proses data input dari form jika ada
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            function normalize($criteria, $types)
            {
              $normalized_criteria = [];
              $num_rows = count($criteria);
              $num_cols = count($criteria[0]);

              for ($j = 0; $j < $num_cols; $j++) {
                $col_values = array_column($criteria, $j);
                $min_val = min($col_values);
                $max_val = max($col_values);

                for ($i = 0; $i < $num_rows; $i++) {
                  if ($types[$j] == 'c') {
                    $normalized_criteria[$i][$j] = $min_val / $criteria[$i][$j];
                  } else {
                    $normalized_criteria[$i][$j] = $criteria[$i][$j] / $max_val;
                  }
                }
              }
              return $normalized_criteria;
            }

            function calculateV($normalized_criteria, $weights)
            {
              $vs = [];
              foreach ($normalized_criteria as $criteria_row) {
                $v = 0;
                foreach ($criteria_row as $j => $criteria_value) {
                  $v += $criteria_value * $weights[$j];
                }
                $vs[] = $v;
              }
              return $vs;
            }

            $normalized_criteria = normalize($criteria, $types);
            $vs = calculateV($normalized_criteria, $weights);

            // Mengurutkan hasil berdasarkan nilai v dari tertinggi ke terendah
            $ranked_vs = $vs;
            $rankings = array_keys($ranked_vs);

            // Membuat array untuk menampilkan data ranking
            $ranked_results = [];
            foreach ($rankings as $rank => $index) {
              $ranked_results[] = [
                'alternative' => $alternative_names[$index],
                'value' => $vs[$index],
                'rank' => $rank + 1
              ];
            }
          }
          ?>
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
                          <input class="typeahead" type="number" id="num_criteria" name="num_criteria" value="<?= $num_criteria ?>" min="1" max="100" required placeholder="Masukkan jumlah Kriteria">
                        </div>
                      </div>
                      <div class="col">
                        <label>Alternatif</label>
                        <div id="bloodhound">
                          <input class="typeahead" type="number" id="num_alternatives" name="num_alternatives" value="<?= $num_alternatives ?>" min="2" max="100" required placeholder="Masukkan jumlah Alternatif">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between w-100">
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
              const num_criteria = document.getElementById('num_criteria').value;
              const num_alternatives = document.getElementById('num_alternatives').value;

              let criteriaInputs = '<table class="table-responsive w-100"><thead><tr><th>Criteria</th>';
              for (let i = 1; i <= num_criteria; i++) {
                criteriaInputs += '<th>C' + i + '</th>';
              }
              criteriaInputs += '</tr></thead><tbody>';

              // Row for attribute names
              criteriaInputs += '<tr><td><input class="btn border-0 text-right" type="text" name="alternative_names" class="form-control" value="Type" placeholder="Alternative" readonly disabled></td>';
              for (let j = 0; j < num_criteria; j++) {
                let defaultChecked = <?= json_encode($types) ?>[j] ? <?= json_encode($types) ?>[j] : 'b';
                let selectClass = defaultChecked === 'b' ? 'btn btn-inverse-success dropdown-toggle p-2' : 'btn btn-inverse-warning dropdown-toggle p-2';

                criteriaInputs += '<td><select class="' + selectClass + '" style="width: 100px;" name="types[' + j + ']" required>';
                criteriaInputs += '<option value="b" ' + (defaultChecked === 'b' ? 'selected' : '') + ' selected>Benefit</option>';
                criteriaInputs += '<option value="c" ' + (defaultChecked === 'c' ? 'selected' : '') + '>Cost</option>';
                criteriaInputs += '</select></td>';
              }
              criteriaInputs += '</tr>';

              // Row for weights
              criteriaInputs += '<tr><td><input class="btn border-0 text text-right" type="text" name="alternative_names" class="form-control" value="Bobot" placeholder="Alternative" readonly disabled></td>';
              for (let i = 0; i < num_criteria; i++) {
                criteriaInputs += '<td><input type="number" class="btn btn-inverse-info p-2" style="width: 100px;" name="weights[' + i + ']" class="form-control" step="0.01" value="' + (<?= json_encode($weights) ?>[i] || '') + '" required></td>';
              }
              criteriaInputs += '</tr>';

              // Rows for alternatives
              for (let i = 0; i < num_alternatives; i++) {
                criteriaInputs += '<tr><td><input type="text" name="alternative_names[' + i + ']" class="form-control" value="' + (<?= json_encode($alternative_names) ?>[i] || '') + '" placeholder="Alternative ' + (i + 1) + '" required></td>';
                for (let j = 0; j < num_criteria; j++) {
                  criteriaInputs += '<td><input type="number" style="width: 100px;" name="criteria[' + i + '][' + j + ']" value="' + (<?= json_encode($criteria) ?>[i] && <?= json_encode($criteria) ?>[i][j] ? <?= json_encode($criteria) ?>[i][j] : '') + '" class="form-control numeric-input" step="0.01" required></td>';
                }
                criteriaInputs += '</tr>';
              }
              criteriaInputs += '</tbody></table>';

              document.getElementById('criteriaInputs').innerHTML = criteriaInputs;
              document.getElementById('hitungButton').style.display = 'inline';

              // Add event listeners to handle dynamic class changes based on selected value
              document.querySelectorAll('select[name^="types"]').forEach(function(selectElement) {
                selectElement.addEventListener('change', function(event) {
                  if (event.target.value === 'b') {
                    event.target.className = 'btn btn-inverse-success dropdown-toggle p-2';
                  } else {
                    event.target.className = 'btn btn-inverse-warning dropdown-toggle p-2';
                  }
                });
              });
            }
            // Call generateInputs() when the page loads
            document.addEventListener('DOMContentLoaded', generateInputs);
          </script>

          <script>
            function resetForm() {
              const num_criteria = document.getElementById('num_criteria').value;
              const num_alternatives = document.getElementById('num_alternatives').value;

              let criteriaInputs = '<table class="table-responsive w-100"><thead><tr><th>Criteria</th>';
              for (let i = 1; i <= num_criteria; i++) {
                criteriaInputs += '<th>C' + i + '</th>';
              }
              criteriaInputs += '</tr></thead><tbody>';

              criteriaInputs += '<tr><td><input class="btn border-0 text-right" type="text" name="alternative_names" class="form-control" value="Kriteria" placeholder="Alternative" readonly disabled></td>';
              for (let j = 0; j < num_criteria; j++) {
                criteriaInputs += '<td><select class="btn btn-inverse-success dropdown-toggle p-2" style="width: 100px;" name="types[' + j + ']" required>';
                criteriaInputs += '<option value="b" selected>Benefit</option>';
                criteriaInputs += '<option value="c">Cost</option>';
                criteriaInputs += '</select></td>';
              }
              criteriaInputs += '</tr>';

              // Row for weights
              criteriaInputs += '<tr><td><input class="btn border-0 text text-right" type="text" name="alternative_names" class="form-control" value="Bobot" placeholder="Alternative" readonly disabled></td>';
              for (let i = 0; i < num_criteria; i++) {
                criteriaInputs += '<td><input type="number" class="btn btn-inverse-info p-2" style="width: 100px;" name="weights[' + i + ']" class="form-control" step="any" value="" required></td>';
              }
              criteriaInputs += '</tr>';

              // Rows for alternatives
              for (let i = 0; i < num_alternatives; i++) {
                criteriaInputs += '<tr><td><input type="text" name="alternative_names[' + i + ']" class="form-control" value="" placeholder="Alternative ' + (i + 1) + '" required></td>';
                for (let j = 0; j < num_criteria; j++) {
                  criteriaInputs += '<td><input type="number" style="width: 100px;" name="criteria[' + i + '][' + j + ']" value="" class="form-control numeric-input" required></td>';
                }
                criteriaInputs += '</tr>';
              }
              criteriaInputs += '</tbody></table>';

              document.getElementById('criteriaInputs').innerHTML = criteriaInputs;
              document.getElementById('hitungButton').style.display = 'inline';

              // Add event listeners to handle dynamic class changes based on selected value
              document.querySelectorAll('select[name^="types"]').forEach(function(selectElement) {
                selectElement.addEventListener('change', function(event) {
                  if (event.target.value === 'b') {
                    event.target.className = 'btn btn-inverse-success dropdown-toggle p-2';
                  } else {
                    event.target.className = 'btn btn-inverse-warning dropdown-toggle p-2';
                  }
                });
              });
            }
            // Call generateInputs() when the page loads
            document.addEventListener('DOMContentLoaded', generateInputs);
          </script>
        </div>
        <div class="row ">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                  <h4>Kriteria</h4>
                  <div class="table-responsive w-100 table-bordered">
                    <table class="table table-hover">
                      <tr class="table btn-inverse-warning">
                        <th>Alternatif</th>
                        <?php foreach (range(1, $num_criteria) as $col) : ?>
                          <th>C<?= $col ?></th>
                        <?php endforeach; ?>
                      </tr>
                      <tr>
                        <td class="table-dark text-right text-muted">Kriteria</td>
                        <?php foreach ($types as $type) : ?>
                          <td class="table-dark <?= ($type == 'b') ? 'text-success' : 'text-danger text' ?>">
                            <?= ($type == 'b') ? 'Benefit' : 'Cost' ?>
                          </td>
                        <?php endforeach; ?>
                      </tr>
                      <tr>
                        <td class="table-dark text-right text-muted">Bobot</td>
                        <?php foreach ($weights as $weight) : ?>
                          <td class="table-dark text-info"><?= $weight ?></td>
                        <?php endforeach; ?>
                      </tr>
                      <?php
                      $highlighted_values = [];
                      foreach (range(0, $num_criteria - 1) as $j) {
                        $col_values = array_column($criteria, $j);
                        if (!empty($col_values)) {
                          if ($types[$j] == 'c') {
                            $highlighted_values[$j] = min($col_values);
                          } else {
                            $highlighted_values[$j] = max($col_values);
                          }
                        } else {
                          $highlighted_values[$j] = null; // Set to null or some default value
                        }
                      }
                      foreach ($criteria as $i => $row) : ?>
                        <tr>
                          <td class="table-dark text-light font-weight-medium"><?= $alternative_names[$i] ?></td>
                          <?php foreach ($row as $j => $item) : ?>
                            <td class="<?= ($item == $highlighted_values[$j] && $types[$j] == 'c') ? 'text-danger' : (($item == $highlighted_values[$j] && $types[$j] == 'b') ? 'text-success' : '') ?>"><?= $item ?> <i class="<?= ($item == $highlighted_values[$j] && $types[$j] == 'c') ? 'mdi mdi-arrow-down small' : (($item == $highlighted_values[$j] && $types[$j] == 'b') ? 'mdi mdi-arrow-up small' : '') ?>"></i> </td>
                          <?php endforeach; ?>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>


                  <h4 class="mt-5">Proses Perhitungan Normalisasi</h4>
                  <p class="text-muted" style="line-height: 0.5;">*Klik tombol dibawah ini untuk melihat penjelasan</p>
                  <button class="btn btn-inverse-info w-100 mb-2" type="button" data-toggle="collapse" data-target="#collapseContent" aria-expanded="false" aria-controls="collapseContent">
                    <i class="mdi mdi-arrow-down-drop-circle text-info"></i>
                  </button>
                  <div class="collapse" id="collapseContent">
                    <div class="card card-body">
                      <p class="text small">
                        <mark class="bg-success">Kriteria Benefit :</mark>
                        <mark class="bg-dark text-light">R<span class="text small">ii</span> = ( <span class="text-muted">X<span class="text small">ij</span></span> / <span class="text text-success">max{X<span class="text small">ij</span>}</span>)</mark><br>
                        Maksud dari rumus diatas adalah : <br>
                        R<span class="text small">ii</span> : Nilai normalisasi dari alternatif i pada kriteria j <br>
                        <span class="text-muted">X<span class="text small">ij</span></span> : Nilai asli dari alternatif i pada kriteria j <br>
                        <span class="text text-success">max{X<span class="text small">ij</span>}</span> : Nilai maksimum dari semua alternatif pada kriteria j <br>
                        <mark class="bg-light">Penjelasan : Setiap nilai pada kolom dengan kriteria benefit dibagi dengan nilai tertinggi dari kolom tersebut</mark>
                      </p>
                      <p class="text small">
                        <mark class="bg-danger">Kriteria Cost :</mark>
                        <mark class="bg-dark text-light">R<span class="text small">ii</span> = ( <span class="text text-danger">min{X<span class="text small">ij</span>}</span> / <span class="text-muted">X<span class="text small">ij</span></span>)</mark>
                        <br>
                        Maksud dari rumus diatas adalah : <br>
                        R<span class="text small">ii</span> : Nilai normalisasi dari alternatif i pada kriteria j <br>
                        <span class="text-muted">X<span class="text small">ij</span></span> : Nilai asli dari alternatif i pada kriteria j <br>
                        <span class="text text-danger">min{X<span class="text small">ij</span>}</span> : Nilai minimum dari semua alternatif pada kriteria j <br>
                        <mark class="bg-light">Penjelasan : Nilai terendah pada kolom dengan kriteria benefit dibagi dengan Setiap nilai pada kolom tersebut </mark>
                      </p>
                    </div>
                  </div>
                  <div class="table-responsive w-100 table-bordered">
                    <table class="table table-hover">
                      <tr class="table bg-info text-light table-contextual">
                        <th>Alternatif</th>
                        <?php foreach (range(1, $num_criteria) as $col) : ?>
                          <th>C<?= $col ?></th>
                        <?php endforeach; ?>
                      </tr>
                      <tr>
                        <td class="table-dark text-right text-muted">Kriteria</td>
                        <?php foreach ($types as $type) : ?>
                          <td class="table-dark <?= ($type == 'b') ? 'text-success' : 'text-danger text' ?>">
                            <?= ($type == 'b') ? 'Benefit' : 'Cost' ?>
                          </td>
                        <?php endforeach; ?>
                      </tr>
                      <?php foreach ($normalized_criteria as $i => $row) : ?>
                        <tr>
                          <td class="table-dark text-light font-weight-medium"><?= $alternative_names[$i] ?></td>
                          <?php
                          foreach ($criteria[$i] as $j => $value) {
                            if ($types[$j] == 'c') {
                              $normalized_value = $highlighted_values[$j] / $value;
                              echo "<td><span class='text-danger'>{$highlighted_values[$j]}</span> / {$value} = <span class='text-light'>" . number_format($normalized_value, 2) . "</span></td>";
                            } else {
                              $normalized_value = $value / $highlighted_values[$j];
                              echo "<td>{$value} / <span class='text-success'>{$highlighted_values[$j]}</span> = <span class='text-light'>" . number_format($normalized_value, 2) . "</span></td>";
                            }
                          }
                          ?>

                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>

                  <h4 class="mt-5">Normalisasi</h4>
                  <div class="table-responsive w-100 table-bordered mb-5">
                    <table class="table table-hover text-light">
                      <tr class="table btn-inverse-warning">
                        <th>No</th> <!-- Tambahkan kolom untuk nomor -->
                        <th>Alternatif</th>
                        <?php foreach (range(1, $num_criteria) as $col) : ?>
                          <th>C<?= $col ?></th>
                        <?php endforeach; ?>
                      </tr>
                      <?php foreach ($normalized_criteria as $i => $row) : ?>
                        <tr>
                          <td class="table-dark text-light font-weight-medium"><?= $i + 1 ?></td> <!-- Tambahkan nomor urut -->
                          <td class="table-dark text-light font-weight-medium"><?= $alternative_names[$i] ?></td>
                          <?php foreach ($row as $j => $item) : ?>
                            <td><?= number_format($item, 2) ?></td>
                          <?php endforeach; ?>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>

                  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <h4>Proses Perhitungan Nilai Akhir</h4>
                    <div class="table-responsive w-100 table-bordered">
                      <table class="table table-hover">

                        <tr class="table bg-info text-light table-contextual">
                          <th>Alternatif</th>
                          <th>Proses Perhitungan</th>
                          <th>Hasil</th>
                        </tr>

                        <?php foreach ($normalized_criteria as $i => $row) : ?>
                          <tr>
                            <td class="table-dark text-light font-weight-medium"><?= $alternative_names[$i] ?></td>
                            <td>
                              <?php
                              $calculation_process = '';
                              foreach ($row as $j => $value) {
                                $calculation_process .= "(<span class='text-info'>{$weights[$j]}</span> * " . number_format($value, 2) . ") + ";
                              }
                              $calculation_process = rtrim($calculation_process, ' + ');
                              echo $calculation_process;
                              ?>
                            </td>
                            <td class="table-dark text-info"><?= number_format($vs[$i], 3) ?></td>
                          </tr>
                        <?php endforeach; ?>

                      </table>
                    </div>
                  <?php endif; ?>


                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Hasil Akhir</h4>
                          <div class="row">
                            <div class="col-md-5">
                              <div class="mb-3">
                                <input type="text" id="search-input" class="form-control" placeholder="Cari Nama">
                              </div>
                              <div class="table-responsive h-75" style="overflow-y: scroll;">
                                <table class="table">
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
                                  <thead class="table position-sticky" style="top: 0; background-color: #191c24; z-index: 1000;">
                                    <tr>
                                      <th>#</th>
                                      <th>Nama</th>
                                      <th id="nilai-header" class="sortable" style="cursor: pointer;">Nilai</th>
                                    </tr>
                                  </thead>
                                  <tbody id="table-body">
                                    <?php
                                    $max_value = max(array_column($ranked_results, 'value'));
                                    ?>

                                    <?php foreach ($ranked_results as $index => $result) : ?>
                                      <tr>
                                        <td>
                                          <?= $result['value'] == $max_value ? '<span>👑</span>' : 'A' . ($index + 1) ?>
                                        </td>
                                        <td>
                                          <?= $result['value'] == $max_value ? '<span class="text-warning">' . $result['alternative'] . '</span>' : '<span class="text-muted">' . $result['alternative'] . '</span>' ?>
                                        </td>
                                        <td>
                                          <?= $result['value'] == $max_value ? '<span class="text-warning">' . number_format($result['value'], 3) . '</span>' : '<span class="text-muted">' . number_format($result['value'], 3) . '</span>' ?>
                                        </td>
                                      </tr>
                                    <?php endforeach; ?>

                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <canvas id="barChart" style="height: 750px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <script>
                    const alternatives = <?= json_encode(array_column($ranked_results, 'alternative')) ?>;
                    const values = <?= json_encode(array_column($ranked_results, 'value')) ?>;
                    const maxValue = Math.max(...values);
                    const minValue = Math.min(...values);

                    // Generate labels A1, A2, A3, ...
                    const labels = alternatives.map((_, index) => `A${index + 1}`);

                    const data = {
                      labels: labels,
                      datasets: [{
                        label: 'Nilai Alternatif',
                        data: values,
                        backgroundColor: values.map(value => {
                          if (value === maxValue) return 'rgba(47, 178, 67, 0.2)'; // Green for max
                          if (value === minValue) return 'rgba(255, 99, 132, 0.2)'; // Red for min
                          return 'rgba(234, 163, 32, 0.2)'; // Grey for others
                        }),
                        borderColor: values.map(value => {
                          if (value === maxValue) return 'rgba(47, 178, 67, 1)'; // Green for max
                          if (value === minValue) return 'rgba(255, 99, 132, 1)'; // Red for min
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
                          let alternative = row.cells[1].innerText.toLowerCase();
                          if (alternative.includes(filter)) {
                            row.style.display = '';
                          } else {
                            row.style.display = 'none';
                          }
                        });
                      }
                    });
                  </script>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>

</html>