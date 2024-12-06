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

function traverseMaze(int $posY, int $posX, array $grid) : array
{
	$ret = [
		'seen' => [],
		'loop' => false,
	];
	$direction = Directions::UP;

	do
	{
		[$dy, $dx] = DIRECTION_VECTORS[$direction->value];

		$newPosY = $posY + $dy;
		$newPosX = $posX + $dx;

		if (isset($ret['seen'][$posY][$posX][$direction->value]))
		{
			$ret['loop'] = true;
			break;
		}

		$ret['seen'][$posY][$posX][$direction->value] = true;

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

	return $ret;
}

['seen' => $traverse] = traverseMaze($posY, $posX, $grid);

$loops = 0;

unset($traverse[$posY][$posX]);

foreach ($traverse as $y => $line)
{
	foreach ($line as $x => $char)
	{
		$newGrid = $grid;

		$newGrid[$y][$x] = '#';

		$loops += traverseMaze($posY, $posX, $newGrid)['loop'];
	}
}

echo $loops, "\n";
