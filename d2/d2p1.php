<?php

$f = fn(string $report) => explode(' ', $report);

$reports = array_map($f, explode("\n", rtrim(file_get_contents('d2.txt'))));

$safeReports = 0;

const STRT = 0;
const INCR = 1;
const DECR = 2;

foreach ($reports as $report)
{
	$state = STRT;
	for ($i = 0, $j = 1; $j < count($report); $i++, $j++)
	{
		$curr = $report[$i];
		$next = $report[$j];
		machine:
		switch ($state)
		{
			case STRT:
				if ($curr === $next)
				{
					continue 3;
				}

				if ($curr < $next)
				{
					$state = INCR;
					goto machine;
				}

				if ($curr > $next)
				{
					$state = DECR;
					goto machine;
				}
			break;
			case INCR:
				$diff = $next - $curr;
			break;
			case DECR:
				$diff = $curr - $next;
			break;
		}

		if ($diff <= 0 || $diff > 3)
		{
			continue 2;
		}
	}

	$safeReports++;
}

echo $safeReports, "\n";
