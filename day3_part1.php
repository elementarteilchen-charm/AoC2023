<?php
class PartNumber
{
    public int $len;
    public int $end_pos;
    public $left_neighbour = '.';
    public $right_neighbour = '.';
    public bool $is_valid = false;

    public function __construct(public int $line_nr, public string $number, public int $start_pos)
    {
        $this->len = strlen($this->number);
        $this->end_pos = $this->start_pos + $this->len - 1; // 0 based indexing
    }

}
class Schematic 
{
    protected array $data;
    public array $lines;
    public array $line_data;
    public int $line_count = 0;
    public int $current_line_nr = 0;
    public array $part_numbers;
    
    public function __construct() 
    {
        $this->data = ["467..114..", "...*......", "..35..633.", "......#...", "617*......",
                ".....+.58.", "..592.....", "......755.", "...$.*....", ".664.598..",
                "................942.......*...874...*......407...558............752......*196.274.240.345...*.....-..105...................164...........466"
            ];
        $this->lines = $this->data;
    }

    public function parse() 
    {
        foreach($this->data as $line_nr => $line) {
            $this->getNumbers($line_nr, $line);
            $this->line_data[] = str_split($line);
        }
        $this->line_count = count($this->line_data);
    }

    public function getNumbers(int $line_nr, string $line)
    {
        $matches = [];
        $pattern = "/\d+/";
        if (preg_match_all($pattern, $line, $matches, PREG_OFFSET_CAPTURE)) {
            foreach($matches[0] as $match) {
                $this->part_numbers[] = new PartNumber($line_nr, $match[0], $match[1]);
            }
        }
    }

    public function getNeighboursOnSameLine(PartNumber $pnr)
    {
        // we only care for symbols other than '.'
        $pnr->left_neighbour = '.';
        if($pnr->start_pos > 0) {
            $pnr->left_neighbour = $this->line_data[$pnr->line_nr][$pnr->start_pos - 1];    
            
            echo "+#+#+ Found a left_neighbour: {$pnr->left_neighbour}" . PHP_EOL;
        } 
        
        $pnr->right_neighbour = '.';
        if($pnr->end_pos < count($this->line_data[$pnr->line_nr])) {
            $pnr->right_neighbour = $this->line_data[$pnr->line_nr][$pnr->end_pos + 1];
            echo "+#+#+ Found a  right_neighbour: {$pnr->right_neighbour}" . PHP_EOL;
        } 
    }

    public function validatePartNumbers()
    {
        foreach($this->part_numbers as $part_number) {
            echo "\nChecking line {$part_number->line_nr} : " . PHP_EOL;
            echo $this->lines[$part_number->line_nr] . PHP_EOL;

            // links und rechts prüfen
            $this->getNeighboursOnSameLine($part_number);
            print_r($part_number);

            $line_length = count($this->line_data[$part_number->line_nr]);
            
            $left = ($part_number->start_pos > 0) ? ($part_number->start_pos - 1) : 0;
            $right = ($part_number->end_pos < $line_length) ? ($part_number->end_pos + 1) : $line_length;
            
            echo "line $part_number->line_nr start: $left, end: $right" . PHP_EOL;
            
            $symbol_left = $this->array_get(
                                $part_number->start_pos - 1, 
                                $this->line_data[$part_number->line_nr],
                                0);
            $symbol_right = $this->array_get(
                                $part_number->end_pos + 1, 
                                $this->line_data[$part_number->line_nr],
                                $line_length);
            
            // echo "### Slice".PHP_EOL;
            // print_r(
            //     array_slice(
            //         $this->line_data[$part_number->line_nr], 
            //         $left, 
            //         $right));

            [$above, $below] = [$part_number->line_nr - 1, $part_number->line_nr + 1];
            [$symbols_above, $symbols_below] = [[], []];
             
            if ($above > 0) {
                // len, not $right
                $symbols_above = array_slice($this->line_data[$above], $left, $right);
            }
            if ($below < $this->line_count) {
                $symbols_below = array_slice($this->line_data[$below], $left, $right);
            }
            
            echo "\tSymbols: $symbol_left :: $symbol_right" . PHP_EOL;
            echo "\tAbove: " . print_r($symbols_above, true) . PHP_EOL;
            echo "\tbelow: " . print_r($symbols_below, true) . PHP_EOL;
            $symbols = array_merge($symbols_above, $symbols_below, [$symbol_left, $symbol_right]);
            $symbols = array_unique($symbols);
            echo "*** Result: " . PHP_EOL;
            print_r($symbols);

            // oben und unten
            //diagonal
        }
    }

    public function array_get(string|int $key, array $array, $default = 0)
    {
        if(array_key_exists($key, $array)) {
            return $array[$key];
        }
        return $default;
    }
}

$schematic = new Schematic();
$schematic->parse();
$schematic->validatePartNumbers();
