<?php
$gamedata = file(filename: '/Users/alex/Documents/web-projects/AoC2023/day2_input.txt');

// Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
// Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue

// The Elf would first like to know which games 
// would have been possible 
// if the bag contained only 12 red cubes, 13 green cubes, and 14 blue cubes?

$cubes_in_bag = [
    'red' => 12, 'green' => 13, 'blue' => 14
];
$sum = [];

foreach ($gamedata as $game) {
    echo $game;
    
    $game_stats = ['red' => 0, 'green' => 0, 'blue' => 0];

    [$game_id_str, $data] = explode(':', $game);
    $game_id = explode(' ', trim($game_id_str))[1];

    $sets_of_cubes = explode(';', $data);
    
    foreach ($sets_of_cubes as $set) {
        $cube_colors = explode(',', $set);
        
        foreach ($cube_colors as $item) {
            [$count, $color] = explode(' ', trim($item));
            $game_stats[$color] = $count;
        }

        $accept = true;
        foreach (['red', 'green', 'blue'] as $color) {
            if ($game_stats[$color] > $cubes_in_bag[$color])
                $accept = false;
        }
    
        // darf man nur 1 mal pro Game berücksichtigen
        if ($accept) {
            $sum[$game_id] = $game_id;
        } else {
            $sum[$game_id] = 0;
            break;
        }   
    }
}
echo array_sum($sum);