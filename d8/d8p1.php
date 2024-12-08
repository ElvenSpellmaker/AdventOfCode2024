<?php

$grid = array_map('str_split', explode("\n", rtrim(file_get_contents('d8.txt'))));

$gridSizeY = count($grid);
$gridSizeX = count($grid[0]);

$antennae = [];

foreach ($grid as $y => $line)
{
	foreach ($line as $x => $char)
	{
		if ($char !== '.')
		{
			$antennae[$char][] = [$y, $x];
		}
	}
}

$seen = [];

function updateAntinodes(int $y, int $x, array $point1, array $point2) : void
{
	global $gridSizeY, $gridSizeX, $seen;

	[$oneY, $oneX] = $point1;
	[$twoY, $twoX] = $point2;

	if (
		(
			$y === $oneY && $x === $oneX
		)
		||
		(
			$y === $twoY && $x === $twoX
		)
		|| $y < 0
		|| $y >= $gridSizeY
		|| $x < 0
		|| $x >= $gridSizeX
	)
	{
		return;
	}

	$seen["$y:$x"] = true;
}

foreach ($antennae as $typeAntennae)
{
	foreach ($typeAntennae as $i => $typeAntenna)
	{
		for ($i = $i + 1; $i < count($typeAntennae); $i++)
		{
			[$oneY, $oneX] = $typeAntenna;
			[$twoY, $twoX] = $typeAntennae[$i];

			$diffY = $twoY - $oneY;
			$diffX = $twoX - $oneX;

			updateAntinodes($oneY + $diffY, $oneX + $diffX, $typeAntenna, $typeAntennae[$i]);
			updateAntinodes($oneY - $diffY, $oneX - $diffX, $typeAntenna, $typeAntennae[$i]);

			updateAntinodes($twoY + $diffY, $twoX + $diffX, $typeAntenna, $typeAntennae[$i]);
			updateAntinodes($twoY - $diffY, $twoX - $diffX, $typeAntenna, $typeAntennae[$i]);
		}
	}
}

echo count($seen), "\n";
