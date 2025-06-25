<?php

function findTargetIndexes($words, $target) {
    $indexes = [];

    foreach ($words as $index => $word) {
        if ($word === $target) { 
            $indexes[] = $index;
        }
    }

    return $indexes;
}
// User inpt
echo "Enter the list of words (comma-separated):\n";
$inputLine = trim(fgets(STDIN));
$words = array_map('trim', explode(',', $inputLine));
echo "Enter the target word:\n";
$target = trim(fgets(STDIN)); 
$result = findTargetIndexes($words, $target);
if (count($result) > 0) {
    echo "Indexes: [" . implode(", ", $result) . "]\n";
} else {
    echo "Target word not found in the list.\n";
}
