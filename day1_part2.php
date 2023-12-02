<?php

$content = file(filename: '/Users/alex/Documents/web-projects/AoC2023/day1_input.txt');
$strings = $content;

// Testdata
# $strings = ['1abc2', 'pqr3stu8vwx', 'a1b2c3d4e5f', 'treb7uchet'];
# echo $strings;
# $strings = ['two1nine','eightwothree','abcone2threexyz','xtwone3four','4nineeightseven2','zoneight234','7pqrstsixteen'];

$pattern = "/(one|two|three|four|five|six|seven|eight|nine)/";
$sub = [
  'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 
  'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9
];

$sum = 0; 
$values = []; // collect individual values for each line for debugging

foreach($strings as $string) {
    // first check if there are and "digit"-words in the string
    // if so, then replace them with actual digits

    $original_string = $string; // for debugging

    $matches =[]; 
    $found = preg_match_all($pattern, $string, $matches, PREG_PATTERN_ORDER);
    
    if ($found) {
        foreach($matches[1] as $match) { 
            // replace words with digits
            $string = str_replace($match, $sub[$match], $string);
        }
    }
  
    // secondly go through the string and find the first and last digit in string
    $digits = [];
    foreach(str_split($string) as $char) {
        if (is_numeric($char)) {
            $digits[] = $char;
        }
    }

    $first = array_shift($digits);
    $last = array_pop($digits) ?: $first;
    $value = intval("$first$last");
    // $values[] = $value; // debugging
    $sum = $sum + $value;
    # echo "$original_string => $string | $first, $last => $value" . PHP_EOL;
}

echo "Sum: $sum";
