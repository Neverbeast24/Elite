<?php
// shortest word

function getShortestWordLength($sentence) {
    $words = explode(" ", $sentence);
    $shortestLength = PHP_INT_MAX;
    foreach ($words as $word) {
        $wordLength = strlen($word);
        if ($wordLength < $shortestLength) {
            $shortestLength = $wordLength;
        }
    }
    return $shortestLength;
}
echo "Shortest Length of a Word\n";
echo "Enter a sentence:";
$input = trim(fgets(STDIN)); 
$shortestLength = getShortestWordLength($input);
echo "Shortest word length: $shortestLength\n";
?>