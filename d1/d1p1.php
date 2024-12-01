<?php

$file = file_get_contents('d1.txt');

preg_match_all('%(\d+)   (\d+)%', $file, $matches);

[, $l1, $l2] = $matches;

sort($l1);
sort($l2);

$sum = 0;

for ($i = 0; $i < count($l1); $i++)
{
	$sum += abs($l1[$i] - $l2[$i]);
}

echo $sum, "\n";
