<?php

$file = file_get_contents('d3.txt');

preg_match_all('%mul\((\d{1,3}),(\d{1,3})\)%', $file, $matches);

$sum = 0;

for ($i = 0; $i < count($matches[1]); $i++)
{
	$sum += $matches[1][$i] * $matches[2][$i];
}

echo $sum, "\n";
