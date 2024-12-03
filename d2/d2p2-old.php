<?php

$f = fn(string $report) => explode(' ', $report);

$reports = array_map($f, explode("\n", rtrim(file_get_contents('d2.txt'))));

$safeReports = 0;

const STRT = 0;
const INCR = 1;
const DECR = 2;

$unsafeReports = [];
$unsafe = false;

start_machine:
foreach ($reports as $report)
{
	echo "\n", join(', ', $report), "\n";
	$state = STRT;
	$repCount = count($report);
	$oneRemove = $unsafe;
	for ($i = 0, $j = 1; $j < $repCount; $i++, $j++)
	{
		$curr = $report[$i];
		$next = $report[$j];

		machine:
		echo "CURR: $curr - NEXT: $next\n";
		switch ($state)
		{
			case STRT:
				if ($curr === $next)
				{
					$diff = 0;
					break;
				}

				if ($curr < $next)
				{
					echo "MODE: INCR\n";
					$state = INCR;
					goto machine;
				}

				if ($curr > $next)
				{
					echo "MODE: DECR\n";
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

		echo "DIFF: $diff\n";

		if ($diff <= 0 || $diff > 3)
		{
			echo "DIFF FAIL\n";

			if ($oneRemove === true)
			{
				// Beginning cases build up...
				$unsafeReports[] = array_slice($report, 1);
				continue 2;
			}

			// End-case...
			if (++$j >= $repCount)
			{
				echo "END CASE\n";
				break;
			}

			if ($i === 0)
			{
				echo "RESTART\n";
				$state = STRT;
			}

			if ($i === 1)
			{
				echo "1RESTART\n";
				$state = STRT;
				$curr = $report[0];
				$i = 0;
				$j = 2;
			}

			$oneRemove = true;

			$i++;

			$next = $report[$j];
			echo "curr: $curr, next: $next\n";
			goto machine;
		}
	}

	echo "^ SAFE\n";

	$safeReports++;
}

if (! $unsafe && count($unsafeReports))
{
	$unsafe = true;

	$reports = $unsafeReports;

	echo "UNSAFE GO\n\n";

	goto start_machine;
}

echo $safeReports, "\n";
