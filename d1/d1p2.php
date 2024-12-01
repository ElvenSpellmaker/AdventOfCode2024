<?php

$file = file_get_contents('d1.txt');

preg_match_all('%(\d+)   (\d+)%', $file, $matches);

[, $l1, $l2] = $matches;

$sum = 0;

$scores = [];

foreach ($l1 as $num)
{
	if (array_key_exists($num, $scores))
	{
		$sum += $scores[$num];
		continue;
	}

	$times = 0;

	foreach ($l2 as $k => $val)
	{
		$same = $num === $val;
		if ($same)
		{
			unset($l2[$k]);

			$times += $same;
		}
	}

	$score = $num * $times;

	$scores[$num] = $score;
	$sum += $score;
}

echo $sum, "\n";
