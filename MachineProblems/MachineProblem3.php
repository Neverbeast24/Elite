<?php

function findTargetIndexes($words, $target) {
    $indexes = [];

    foreach ($words as $index => $word) {
        if ($word === $target) { // Exact match, case-sensitive
            $indexes[] = $index;
        }
    }

    return $indexes;
}

$words = ["I", "TWO", "FORTY", "THREE", "JEN", "TWO", "tWo", "Two"];
$target = "TWO";

$result = findTargetIndexes($words, $target);

echo "Indexes: [" . implode(", ", $result) . "]\n";
