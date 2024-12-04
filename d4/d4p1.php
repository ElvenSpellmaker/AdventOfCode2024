<?php

$file = array_map('str_split', explode("\n", rtrim(file_get_contents('d4.txt'))));

const SEARCH_CHARS = [
	'X' => 'M',
	'M' => 'A',
	'A' => 'S',
];

enum Movement {
	case INITIAL;
	case TOP_LEFT;
	case TOP_MIDDLE;
	case TOP_RIGHT;
	case LEFT;
	case RIGHT;
	case BOTTOM_LEFT;
	case BOTTOM_MIDDLE;
	case BOTTOM_RIGHT;
}

function search(int $y, int $x, string $searchChar = 'X', Movement $movement = Movement::INITIAL) : int
{
	global $file;

	if ($file[$y][$x] !== $searchChar)
	{
		return 0;
	}

	if ($searchChar === 'S')
	{
		return 1;
	}

	$searchPos = [];

	// Top Left
	in_array($movement, [Movement::INITIAL, Movement::TOP_LEFT])
		&& isset($file[$y - 1][$x - 1])
		&& $searchPos[] = ['y' => $y - 1, 'x' => $x - 1, 'movement' => Movement::TOP_LEFT];

	// Top Middle
	in_array($movement, [Movement::INITIAL, Movement::TOP_MIDDLE])
		&& isset($file[$y - 1][$x])
		&& $searchPos[] = ['y' => $y - 1, 'x' => $x, 'movement' => Movement::TOP_MIDDLE];

	// Top Right
	in_array($movement, [Movement::INITIAL, Movement::TOP_RIGHT])
		&& isset($file[$y - 1][$x + 1])
		&& $searchPos[] = ['y' => $y - 1, 'x' => $x + 1, 'movement' => Movement::TOP_RIGHT];

	// Left
	in_array($movement, [Movement::INITIAL, Movement::LEFT])
		&& isset($file[$y][$x - 1])
		&& $searchPos[] = ['y' => $y, 'x' => $x - 1, 'movement' => Movement::LEFT];

	// Right
	in_array($movement, [Movement::INITIAL, Movement::RIGHT])
		&& isset($file[$y][$x + 1])
		&& $searchPos[] = ['y' => $y, 'x' => $x + 1, 'movement' => Movement::RIGHT];

	// Bottom Left
	in_array($movement, [Movement::INITIAL, Movement::BOTTOM_LEFT])
		&& isset($file[$y + 1][$x - 1])
		&& $searchPos[] = ['y' => $y + 1, 'x' => $x - 1, 'movement' => Movement::BOTTOM_LEFT];

	// Bottom Middle
	in_array($movement, [Movement::INITIAL, Movement::BOTTOM_MIDDLE])
		&& isset($file[$y + 1][$x])
		&& $searchPos[] = ['y' => $y + 1, 'x' => $x, 'movement' => Movement::BOTTOM_MIDDLE];

	// Top Right
	in_array($movement, [Movement::INITIAL, Movement::BOTTOM_RIGHT])
		&& isset($file[$y + 1][$x + 1])
		&& $searchPos[] = ['y' => $y + 1, 'x' => $x + 1, 'movement' => Movement::BOTTOM_RIGHT];

	return array_reduce($searchPos, fn(int $i, array $a) => $i + search($a['y'], $a['x'], SEARCH_CHARS[$searchChar], $a['movement']), 0);
}

$sum = 0;

foreach ($file as $y => $line)
{
	foreach ($line as $x => $char)
	{
		$sum += search($y, $x, 'X');
	}
}

echo $sum, "\n";
