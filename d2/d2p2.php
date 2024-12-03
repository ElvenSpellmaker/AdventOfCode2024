<?php

$f = fn(string $report) => explode(' ', $report);

$reports = array_map($f, explode("\n", rtrim(file_get_contents('d2.txt'))));

$safeReports = 0;

const STRT = 0;
const INCR = 1;
const DECR = 2;

function generate(array $subReports) : array
{
	$ret = [];

	for ($i = 0; $i < count($subReports); $i++)
	{
		$newReport = $subReports;
		unset($newReport[$i]);

		$ret[] = array_values($newReport);
	}

	return $ret;
}

function safe(array $report) : bool
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
					return false;
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
			return false;
		}
	}

	return true;
}

foreach ($reports as $report)
{
	$newReps = generate($report);
	$newReps[] = $report;

	$safeReports += array_any($newReps, fn(array $rep) => safe($rep));
}

echo $safeReports, "\n";
