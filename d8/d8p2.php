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

function updateAntinodes(int $y, int $x, int $diffY, int $diffX) : void
{
	global $gridSizeY, $gridSizeX, $seen;

	while (
		$y >= 0
		&& $y < $gridSizeY
		&& $x >= 0
		&& $x < $gridSizeX
	)
	{
		$seen["$y:$x"] = true;

		$y += $diffY;
		$x += $diffX;
	}
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

			updateAntinodes($oneY, $oneX, $diffY, $diffX);
			updateAntinodes($oneY, $oneX, -$diffY, -$diffX);
		}
	}
}

echo count($seen), "\n";
