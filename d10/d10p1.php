<?php

$grid = array_map('str_split', explode("\n", rtrim(file_get_contents('d10.txt'))));

enum Dirs : int
{
	case RIGHT = 0;
	case DOWN = 1;
	case LEFT = 2;
	case UP = 3;
}

const NO_DIRS_ARR = [
	Dirs::RIGHT->value => [0, -1],
	Dirs::DOWN->value => [-1, 0],
	Dirs::LEFT->value => [0, 1],
	Dirs::UP->value => [1, 0],
];

const REVERSE  = [
	Dirs::RIGHT->value => Dirs::LEFT->value,
	Dirs::DOWN->value => Dirs::UP->value,
	Dirs::LEFT->value => Dirs::RIGHT->value,
	Dirs::UP->value => Dirs::DOWN->value,
];

$gm = [];

function walkGrid(int $y, int $x, array $dirs) : array
{
	global $grid, $gm;

	$char = $grid[$y][$x];

	$seen = [];

	if ($grid[$y][$x] === '9')
	{
		return ["$y:$x" => true];
	}

	if (isset($gm[$y][$x]))
	{
		return $gm[$y][$x];
	}

	foreach ($dirs as $dirKey => $dir)
	{
		$newY = $y + $dir[0];
		$newX = $x + $dir[1];
		$newChar = (int)($grid[$newY][$newX] ?? -1);

		if ($char + 1 !== $newChar)
		{
			continue;
		}

		$dirs = NO_DIRS_ARR;
		unset($dirs[REVERSE[$dirKey]]);

		$seen += walkGrid($newY, $newX, $dirs);
	}

	$gm[$y][$x] = $seen;

	return $seen;
}

$score = 0;

foreach ($grid as $y => $line)
{
	foreach ($line as $x => $char)
	{
		if ($char !== '0')
		{
			continue;
		}

		$dirs = NO_DIRS_ARR;

		$score += count(walkGrid($y, $x, $dirs));
	}
}

echo $score, "\n";
