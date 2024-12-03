<?php

$file = file_get_contents('d3.txt');

preg_match_all('%mul\((\d{1,3}),(\d{1,3})\)|do\(\)|don\'t\(\)%', $file, $matches);

$sum = 0;
$do = true;

for ($i = 0; $i < count($matches[1]); $i++)
{
	switch ($matches[0][$i])
	{
		case 'do()':
			$do = true;
		break;
		case 'don\'t()':
			$do = false;
		break;
		default:
			$do === true && $sum += $matches[1][$i] * $matches[2][$i];
		break;
	}
}

echo $sum, "\n";
