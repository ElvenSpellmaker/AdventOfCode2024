<?php

$grid = array_map('str_split', explode("\n", rtrim(file_get_contents('d6.txt'))));

enum Directions : int {
	case UP = 0;
	case RIGHT = 1;
	case DOWN = 2;
	case LEFT = 3;
}

const DIRECTION_VECTORS = [
	Directions::UP->value => [-1, 0],
	Directions::RIGHT->value => [0, 1],
	Directions::DOWN->value => [1, 0],
	Directions::LEFT->value => [0, -1],
];

const TURNS = [
	Directions::UP->value => Directions::RIGHT,
	Directions::RIGHT->value => Directions::DOWN,
	Directions::DOWN->value => Directions::LEFT,
	Directions::LEFT->value => Directions::UP,
];

$posY = null;
$posX = null;
$direction = Directions::UP;

$seen = [];

foreach ($grid as $y => $line)
{
	foreach ($line as $x => $char)
	{
		if ($char === '^')
		{
			$posY = $y;
			$posX = $x;
			break 2;
		}
	}
}

do
{
	[$dy, $dx] = DIRECTION_VECTORS[$direction->value];

	$newPosY = $posY + $dy;
	$newPosX = $posX + $dx;

	$seen["$posY:$posX"] = true;

	if (! isset($grid[$newPosY][$newPosX]))
	{
		break;
	}

	if ($grid[$newPosY][$newPosX] === '#')
	{
		$direction = TURNS[$direction->value];
		continue;
	}

	$posY = $newPosY;
	$posX = $newPosX;
}
while(true);

echo count($seen), "\n";
