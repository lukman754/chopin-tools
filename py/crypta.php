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
            if ($digit == 0 && (in_array($char, array_map(fn ($word) => $word[0], $words)) || $char == $result[0])) {
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
<!DOCTYPE html>
<html>

<head>
    <title>Cryptarithm Solver</title>
    <style>
        #loadingBar {
            width: 0;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        #loadingContainer {
            width: 100%;
            background-color: #ddd;
            margin-bottom: 20px;
        }

        .output {
            font-family: monospace;
            white-space: pre;
        }
    </style>
    <script>
        function addWordInput() {
            var container = document.getElementById("wordsContainer");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "words[]";
            input.placeholder = "Enter word";
            container.appendChild(input);
            container.appendChild(document.createElement("br"));
        }

        function showLoadingBar() {
            var loadingContainer = document.getElementById("loadingContainer");
            var loadingBar = document.getElementById("loadingBar");
            loadingContainer.style.display = "block";
            loadingBar.style.width = "0%";
            var width = 0;
            var interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width++;
                    loadingBar.style.width = width + "%";
                    loadingBar.innerHTML = width + "%";
                }
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
                container.appendChild(document.createElement("br"));
            }
            // Clear result input field
            document.getElementsByName('result')[0].value = '';
            // Clear the operation selection
            document.getElementById('operation').selectedIndex = 0;
        }
    </script>
</head>

<body>
    <h2>Cryptarithm Solver</h2>
    <form method="POST" onsubmit="showLoadingBar()">
        <div id="wordsContainer">
            <?php
            if (isset($_POST['words'])) {
                foreach ($_POST['words'] as $word) {
                    echo '<input type="text" name="words[]" value="' . htmlspecialchars($word) . '" placeholder="Enter word"><br>';
                }
            } else {
                echo '<input type="text" name="words[]" placeholder="Enter word"><br>';
                echo '<input type="text" name="words[]" placeholder="Enter word"><br>';
            }
            ?>
        </div>
        <button type="button" onclick="addWordInput()">Add Word</button><br><br>
        <input type="text" name="result" placeholder="Enter result" value="<?php echo isset($_POST['result']) ? htmlspecialchars($_POST['result']) : ''; ?>"><br><br>
        <label for="operation">Operation:</label>
        <select name="operation" id="operation">
            <option value="addition" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'addition') ? 'selected' : ''; ?>>Addition</option>
            <option value="subtraction" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'subtraction') ? 'selected' : ''; ?>>Subtraction</option>
            <option value="multiplication" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'multiplication') ? 'selected' : ''; ?>>Multiplication</option>
            <option value="division" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'division') ? 'selected' : ''; ?>>Division</option>
        </select><br><br>
        <input type="submit" value="Solve">
        <button type="button" onclick="resetForm()">Reset</button>
    </form>

    <div id="loadingContainer" style="display:none;">
        <div id="loadingBar"></div>
    </div>

    <?php
    if ($solution !== null) {
        echo "<h3>Input and Solution:</h3>";

        if (is_array($solution)) {
            list($charToDigit, $words, $wordValues, $resultValue) = $solution;

            // Determine the maximum length for alignment
            $maxLength = max(array_map('strlen', array_merge($wordValues, [$resultValue])));

            // Display input words
            foreach ($words as $word) {
                $number = '';
                foreach (str_split($word) as $char) {
                    $number .= $charToDigit[$char];
                }
                echo "<p class='output'>" . str_pad($number, $maxLength, ' ', STR_PAD_LEFT) . "</p>";
            }

            // Display the operation sign
            switch ($_POST['operation']) {
                case 'addition':
                    echo "<p class='output'>" . str_pad('+', $maxLength, ' ', STR_PAD_LEFT) . "</p>";
                    break;
                case 'subtraction':
                    echo "<p class='output'>" . str_pad('-', $maxLength, ' ', STR_PAD_LEFT) . "</p>";
                    break;
                case 'multiplication':
                    echo "<p class='output'>" . str_pad('×', $maxLength, ' ', STR_PAD_LEFT) . "</p>";
                    break;
                case 'division':
                    echo "<p class='output'>" . str_pad('÷', $maxLength, ' ', STR_PAD_LEFT) . "</p>";
                    break;
            }

            // Display result
            echo "<p class='output'>" . str_pad($resultValue, $maxLength, ' ', STR_PAD_LEFT) . "</p>";

            // Display character mappings
            echo "<h3>Character Mapping:</h3>";
            ksort($charToDigit); // Sort the array by keys (characters) in alphabetical order
            foreach ($charToDigit as $char => $digit) {
                echo "<p>{$char} = {$digit}</p>";
            }
        } else {
            echo "<p>{$solution}</p>";
        }
        echo "<h3>Processing Time:</h3>";
        echo "<p>" . number_format($processingTime, 5) . " seconds</p>";
    }
    ?>
</body>

</html>