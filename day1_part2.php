<?php
$content = file(filename: '/Users/alex/Documents/web-projects/AoC2023/day1_input.txt');
$strings = $content;

#$strings = ['two1nine','eightwothree','abcone2threexyz','xtwone3four','4nineeightseven2','zoneight234','7pqrstsixteen'];
#$string = $strings[1];

# $strings = ['1abc2', 'pqr3stu8vwx', 'a1b2c3d4e5f', 'treb7uchet'];
# echo $strings;

$pattern = "/(one|two|three|four|five|six|seven|eight|nine)/";
$sub = [
  'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 
  'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9
];

$sum = 0; $values = [];
foreach($strings as $string) {
  
    $matches =[]; 
    $original_string = $string;
    $found = preg_match_all($pattern, $string, $matches, PREG_PATTERN_ORDER);
    
    if ($found) {
        foreach($matches[1] as $match) {
            $string = str_replace($match, $sub[$match], $string);
        }
    }
  
    // find first and last digit in string
    $digits = [];
    foreach(str_split($string) as $char) {
        if (is_numeric($char)) {
            $digits[] = $char;
        }
    }

    $first = array_shift($digits);
    $last = array_pop($digits) ?: $first;
    $value = intval("$first$last");
    $values[] = $value;
    $sum = $sum + $value;
    # echo "$original_string => $string | $first, $last => $value" . PHP_EOL;
}
# echo count($values);
$s=0;
foreach($values as $value) { $s = $s+$value;}
# echo $values;
echo "Sum: $sum, $s";
