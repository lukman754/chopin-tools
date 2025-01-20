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
                                            <i class="mdi mdi-scale-balance text pl-5" style="font-size: 40px;"></i>
                                        </div>
                                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                                            <h4 class="mb-1 mb-sm-0">Cryptarithm</h4>
                                            <p class="mb-0 font-weight-normal d-none d-sm-block">mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif di semua atribut.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    function solveCryptarithm($words, $result, $operation)
                    {
                        $uniqueChars = array_unique(str_split(implode('', $words) . $result));
                        if (count($uniqueChars) > 10) {
                            return "Terlalu banyak karakter unik";
                        }

                        return findSolution($uniqueChars, [], $words, $result, $operation);
                    }

                    function findSolution($uniqueChars, $charToDigit, $words, $result, $operation)
                    {
                        if (count($uniqueChars) == 0) {
                            return checkSolution($charToDigit, $words, $result, $operation);
                        }

                        $remainingChars = $uniqueChars;
                        $char = array_shift($remainingChars);

                        for ($digit = 0; $digit <= 9; $digit++) {
                            if (!in_array($digit, $charToDigit)) {
                                $charToDigit[$char] = $digit;

                                // Ensure that the first letter of each word and the result cannot be zero
                                if ($digit == 0 && (in_array($char, array_map(fn($word) => $word[0], $words)) || $char == $result[0])) {
                                    unset($charToDigit[$char]);
                                    continue;
                                }

                                $solution = findSolution($remainingChars, $charToDigit, $words, $result, $operation);
                                if ($solution !== false) {
                                    return $solution;
                                }
                                unset($charToDigit[$char]);
                            }
                        }

                        return false;
                    }

                    function checkSolution($charToDigit, $words, $result, $operation)
                    {
                        if ($charToDigit[$result[0]] == 0) {
                            return false;
                        }

                        $wordValues = [];
                        foreach ($words as $word) {
                            $number = '';
                            foreach (str_split($word) as $char) {
                                $number .= $charToDigit[$char];
                            }
                            $wordValues[] = (int)$number;
                        }

                        $resultValue = '';
                        foreach (str_split($result) as $char) {
                            $resultValue .= $charToDigit[$char];
                        }
                        $resultValue = (int)$resultValue;

                        switch ($operation) {
                            case 'addition':
                                if (array_sum($wordValues) == $resultValue) {
                                    return [$charToDigit, $words, $wordValues, $resultValue];
                                }
                                break;
                            case 'subtraction':
                                if (count($wordValues) == 2 && ($wordValues[0] - $wordValues[1]) == $resultValue) {
                                    return [$charToDigit, $words, $wordValues, $resultValue];
                                }
                                break;
                            case 'multiplication':
                                if (count($wordValues) == 2 && ($wordValues[0] * $wordValues[1]) == $resultValue) {
                                    return [$charToDigit, $words, $wordValues, $resultValue];
                                }
                                break;
                            case 'division':
                                if (count($wordValues) == 2 && ($wordValues[0] / $wordValues[1]) == $resultValue) {
                                    return [$charToDigit, $words, $wordValues, $resultValue];
                                }
                                break;
                            default:
                                return false;
                        }

                        return false;
                    }

                    $solution = null;
                    $processingTime = 0;

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $words = $_POST['words'];
                        $result = $_POST['result'];
                        $operation = $_POST['operation']; // Get the operation type

                        $startTime = microtime(true);
                        $solution = solveCryptarithm($words, $result, $operation);
                        $endTime = microtime(true);

                        $processingTime = $endTime - $startTime;
                    }
                    ?>
                    <script>
                        function addWordInput() {
                            var container = document.getElementById("wordsContainer");
                            var input = document.createElement("input");
                            input.type = "text";
                            input.name = "words[]";
                            input.placeholder = "Enter word";
                            input.className = "form-control text-uppercase w-100 mb-2"; // Menambahkan kelas
                            container.appendChild(input);
                            input.required = true;
                        }


                        function showLoadingBar() {
                            var loadingContainer = document.getElementById("loadingContainer");
                            var loadingBar = document.getElementById("loadingBar");
                            loadingContainer.style.display = "block";
                            loadingBar.style.width = "0%";
                            var width = 0;
                            var interval = setInterval(function() {
                                if (width >= 100) {
                                    width = 0; // Reset to 0%
                                } else {
                                    width++;
                                }
                                loadingBar.style.width = width + "%";
                                loadingBar.innerHTML = width + "%";
                            }, 50);
                        }

                        function resetForm() {
                            var container = document.getElementById("wordsContainer");
                            // Clear all existing inputs in the container
                            container.innerHTML = '';
                            // Add default number of inputs
                            for (var i = 0; i < 2; i++) {
                                var input = document.createElement("input");
                                input.type = "text";
                                input.name = "words[]";
                                input.placeholder = "Enter word";
                                container.appendChild(input);
                                input.required = true;
                                input.className = "form-control text-uppercase w-100 mb-2";

                            }
                            // Clear result input field
                            document.getElementsByName('result')[0].value = '';
                            // Clear the operation selection
                            document.getElementById('operation').selectedIndex = 0;
                        }
                    </script>

                    <form method="post" onsubmit="showLoadingBar()">
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Input Kriteria dan Alternatif</h4>

                                        <div class="table-responsive w-100 ">

                                            <tbody class="table-bordered">
                                                <style>
                                                    .form-control,
                                                    .output {

                                                        text-align: right;
                                                        /* Rata kanan */
                                                        letter-spacing: 10px;
                                                        /* Jarak antar huruf */
                                                        color: white;
                                                    }

                                                    .output2 {

                                                        text-align: center;
                                                        /* Rata kanan */
                                                        letter-spacing: -5px;
                                                        /* Jarak antar huruf */
                                                        color: white;
                                                    }
                                                </style>

                                                <div id="wordsContainer">

                                                    <?php

                                                    $classInput = "form-control text-uppercase w-100 mb-2";


                                                    if (isset($words)) : ?>
                                                        <?php foreach ($words as $word) : ?>
                                                            <tr>
                                                                <td colspan="2"><input class="<?php echo $classInput ?>" type="text" name="words[]" value="<?php echo htmlspecialchars($word); ?>" placeholder="Enter word" required></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>

                                                        <tr>
                                                            <td colspan="2"><input class=" <?php echo $classInput ?>" type="text" name="words[]" placeholder="Enter word" required></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><input class=" <?php echo $classInput ?>" type="text" name="words[]" placeholder="Enter word" required></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </div>
                                                <tr>
                                                    <td>
                                                        <input class="form-control bg-light text-dark text-uppercase w-100 mb-2" type="text" name="result" placeholder="Enter result" value="<?php echo isset($_POST['result']) ? htmlspecialchars($_POST['result']) : ''; ?>" required>
                                                        <div class="d-flex justify-content-between w-100">
                                                            <input class="btn btn-inverse-success btn-fw w-50 mr-1" type="button" onclick="addWordInput()" value="Add Word"></input>
                                                            <select class="btn btn-inverse-warning btn-fw w-50" name="operation" id="operation">
                                                                <option value="addition" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'addition') ? 'selected' : ''; ?>>+</option>
                                                                <option value="subtraction" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'subtraction') ? 'selected' : ''; ?>>-</option>
                                                                <option value="multiplication" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'multiplication') ? 'selected' : ''; ?>>*</option>
                                                                <option value="division" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'division') ? 'selected' : ''; ?>>/</option>
                                                            </select>

                                                        </div>
                                                    </td>


                                                </tr>
                                            </tbody>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between w-100">
                                        <button type="submit" class="btn btn-inverse-primary btn-fw w-50 m-1">Slove</button>
                                        <button type="button" class="btn btn-inverse-danger btn-fw w-50 m-1" onclick="resetForm()">Reset Form</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <style>
                        #loadingContainer {
                            width: 100%;
                            background-color: #14402f;
                            height: 20px;
                            position: relative;
                        }

                        #loadingBar {
                            height: 100%;
                            width: 0%;
                            background-color: #43fe5f;
                            text-align: center;
                            line-height: 20px;
                            color: #14402f;
                            position: absolute;
                        }
                    </style>

                    <div class="row ">

                        <div class="col-md-6 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div id="loadingContainer" style="display:none;">
                                        <div id="loadingBar"></div>
                                    </div>


                                    <?php
                                    if ($solution !== null) {
                                        echo "<h3>Solution:</h3>";
                                        echo "<table class='table table-borderless table-sm borde'>";

                                        if (is_array($solution)) {
                                            list($charToDigit, $words, $wordValues, $resultValue) = $solution;

                                            // Determine the maximum length for alignment
                                            $maxLength = max(array_map('strlen', array_merge($wordValues, [$resultValue])));

                                            // Display input words
                                            foreach ($words as $word) {
                                                $number = '';
                                                foreach (str_split($word) as $char) {
                                                    $number .= $charToDigit[$char];
                                                } ?>
                                                <tr>
                                                    <td class='output text-uppercase  bg-gray-dark'>
                                                        <?= str_pad($word, $maxLength, ' ') ?>
                                                    </td>
                                                    <td class='output text-uppercase  bg-gray-dark'>
                                                        <?= str_pad($number, $maxLength, ' ') ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                            <tr>
                                                <td class='output text-uppercase border-top bg-secondary text-dark'>
                                                    <?= str_pad($result, $maxLength, ' ', STR_PAD_LEFT) ?>
                                                </td>
                                                <td class='output text-uppercase border-top bg-secondary text-dark'>
                                                    <?= str_pad($resultValue, $maxLength, ' ', STR_PAD_LEFT) ?>
                                                </td>
                                            </tr>
                                            </table>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Digit Mapping:</h3>
                                    <div class="table-responsive w-100 ">
                                        <table class="table">
                                            <?php
                                            // Sort the $charToDigit array by keys (characters)
                                            ksort($charToDigit);

                                            foreach ($charToDigit as $char => $digit) {
                                            ?>
                                                <div class="btn-group-vertical btn-group-horizontal mb-1">
                                                    <div class='btn output2 text-uppercase btn-outline-light'><?= $char ?></div>
                                                    <div class='btn output2 text-uppercase btn-outline-light'><?= $digit ?></div>
                                                </div>
                                            <?php
                                            }
                                            ?>


                                        </table>
                                    </div>
                                    <p><strong>Processing Time:</strong> <?= number_format($processingTime, 6) ?> seconds</p>
                                <?php
                                        } else {
                                ?>
                                    <p>No solution found.</p>
                            <?php
                                        }
                                    }
                            ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer bg-transparent">
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