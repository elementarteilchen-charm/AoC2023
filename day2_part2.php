<?php
// $gamedata = ["Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green",
// "Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue",
// "Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red",
// "Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red",
// "Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green"];

$gamedata = file(filename: '/Users/alex/Documents/web-projects/AoC2023/day2_input.txt');
// Correct answer: 59795

$sum = 0;

class GameData 
{
    protected $sets = [];
    protected $current_minimum = ['red' => 0, 'green' => 0, 'blue' => 0];

    public function __construct(protected $game)
    {
        [$game_id_str, $data] = explode(':', $game);
        $this->game_id = explode(' ', trim($game_id_str))[1];

        $sets_of_cubes = explode(';', $data);
    
        foreach ($sets_of_cubes as $set) {
            $cube_colors = explode(',', $set);
        
            foreach ($cube_colors as $item) {
                [$count, $color] = explode(' ', trim($item));
                $game_stats[$color] = $count;
            }
            $this->sets[] = $game_stats;
        }
    }

    public function getMinimum() 
    {
        $this->current_minimum = ['red' => 0, 'green' => 0, 'blue' => 0];
        
        foreach($this->sets as $set) {
            foreach (['red', 'green', 'blue'] as $color) {
                if ($set[$color] > $this->current_minimum[$color]) 
                    $this->current_minimum[$color] = $set[$color];
            }
        }
    }

    public function getPower()
    {
        $this->power = $this->current_minimum['red'] 
                    * $this->current_minimum['green'] 
                    * $this->current_minimum['blue'];
        return $this->power;
    }

    public function __toString()
    {
        return print_r($this,true);
    }
}

foreach ($gamedata as $game) {
    
    $g = new GameData($game);
    $g->getMinimum();
    $sum = $sum + $g->getPower();

}
echo $sum;