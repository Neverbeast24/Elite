<?php
function countIslands(&$matrix) {
    $rows = count($matrix);
    $cols = count($matrix[0]);
    $count = 0;

    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $cols; $j++) {
            if ($matrix[$i][$j] == 1) {
                markIsland($matrix, $i, $j, $rows, $cols);
                $count++;
            }
        }
    }

    return $count;
}

function markIsland(&$matrix, $i, $j, $rows, $cols) {
    if ($i < 0 || $j < 0 || $i >= $rows || $j >= $cols || $matrix[$i][$j] != 1) {
        return;
    }

    $matrix[$i][$j] = -1; // Mark visited

    $directions = [
        [-1, -1], [-1, 0], [-1, 1],
        [ 0, -1],          [ 0, 1],
        [ 1, -1], [ 1, 0], [ 1, 1]
    ];

    foreach ($directions as [$dx, $dy]) {
        markIsland($matrix, $i + $dx, $j + $dy, $rows, $cols);
    }
}

function printMatrixVisual($matrix) {
    foreach ($matrix as $row) {
        $line = '';
        foreach ($row as $val) {
            $line .= ($val == 1 || $val == -1) ? 'X' : '~';
        }
        echo "\"$line\"\n";
    }
}

// === MAIN START ===

echo "Enter number of rows: ";
$rows = (int)trim(fgets(STDIN));

echo "Enter number of columns: ";
$cols = (int)trim(fgets(STDIN));

$matrix = [];

echo "Enter the matrix (space-separated rows of 0s and 1s):\n";
for ($i = 0; $i < $rows; $i++) {
    echo "Row " . ($i + 1) . ": ";
    $line = trim(fgets(STDIN));
    $matrix[] = array_map('intval', explode(" ", $line));
}

echo "\nMatrix Visual:\n";
printMatrixVisual($matrix);

$islands = countIslands($matrix);
echo "\nTotal islands: $islands\n";
?>
