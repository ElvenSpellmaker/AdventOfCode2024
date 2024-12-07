<?php

$line = array_map(fn(string $s) => explode(': ', $s), explode("\n", rtrim(file_get_contents('d7.txt'))));

function performMaths(array $parts, int $pos, int $total, int $carry) : bool
{
	$newPos = $pos + 1;

	if (! isset($parts[$newPos]))
	{
		return $carry === $total;
	}

	$one = $carry + $parts[$newPos];
	$two = $carry * $parts[$newPos];
	$three = $carry . $parts[$newPos];

	return ($one <= $total && performMaths($parts, $newPos, $total, $one))
		|| ($two <= $total && performMaths($parts, $newPos, $total, $two))
		|| ($three <= $total && performMaths($parts, $newPos, $total, $three));
}

$sum = 0;

foreach ($line as [$total, $parts])
{
	$parts = explode(' ', $parts);

	if (performMaths($parts, 0, $total, $parts[0]))
	{
		$sum += $total;
	}
}

echo $sum, "\n";
