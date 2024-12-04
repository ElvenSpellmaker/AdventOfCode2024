<?php

$file = array_map('str_split', explode("\n", rtrim(file_get_contents('d4.txt'))));

$sum = 0;

foreach ($file as $y => $line)
{
	foreach ($line as $x => $char)
	{
		if (
			$char !== 'A'
			|| ! isset($file[$y - 1][$x - 1])
			|| ! isset($file[$y - 1][$x + 1])
			|| ! isset($file[$y + 1][$x - 1])
			|| ! isset($file[$y + 1][$x + 1])
		)
		{
			continue;
		}

		$brCheck = $file[$y - 1][$x - 1] === 'M' ? 'S' : ($file[$y - 1][$x - 1] === 'S' ? 'M' : false);

		if(! $brCheck || $file[$y + 1][$x + 1] !== $brCheck)
		{
			continue;
		}

		$trCheck = $file[$y + 1][$x - 1] === 'M' ? 'S' : ($file[$y + 1][$x - 1] === 'S' ? 'M' : false);

		if(! $trCheck || $file[$y - 1][$x + 1] !== $trCheck)
		{
			continue;
		}

		$sum++;
	}
}

echo $sum, "\n";
