<?php
class Schematic 
{
    protected $data = [];
    
    public function __construct() 
    {
        $this->data = ["467..114..", "...*......", "..35..633.", "......#...", "617*......",
                ".....+.58.", "..592.....", "......755.", "...$.*....", ".664.598.."];
    }

    public function parse() 
    {
        // look at each line
        // get the numbers and the position of each number in the string
        // check if the number is valid
        //  it is valid if $pos-1 or $pos+$len+1 is a symbol
        //  it is valid if in the line above it touches a symbol
        //  it is valid if in the line below it touches a symbol
        // touching = $start_pos-1 to $end_pos+1 contains a symbol

        foreach($this->data as $line) {
            echo $line;
        }
    }

    public function getNumbers()
    {
        $matches = [];
        $pattern = "/\d+/";
        if (preg_match($pattern, $line, $matches, PREG_OFFSET_CAPTURE)) {
            $number = $matches[0];
            echo $number;
        }
        
    }
}


// foreach($data as $key => $line) {
    // echo "$key $line";
    // $found = preg_match($pattern, $line, $matches,PREG_OFFSET_CAPTURE);
    // echo print_r($matches, true);
    // foreach(str_split($line) as $pos => $c) {
    //     echo "$key . $pos $c";
    // }
// }