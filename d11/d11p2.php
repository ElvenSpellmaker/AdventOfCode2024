<?php

$numbers = explode(' ', rtrim(file_get_contents('d11.txt')));

$rounds = 75;

$numbersCount = [];

foreach ($numbers as $number)
{
	$numbersCount[$number] = ($numbersCount[$number] ?? 0) + 1;
}

while ($rounds--)
{
	$newNumbersCount = [];

	foreach ($numbersCount as $number => $count)
	{
		if ($number === 0)
		{
			$newNumbersCount[1] = ($newNumbersCount[1] ?? 0) + $count;
			continue;
		}

		$stoneLen = strlen($number);

		if ($stoneLen % 2 === 0)
		{
			$halfLen = $stoneLen / 2;
			$one = (int)substr($number, 0, $halfLen);
			$two = (int)substr($number, $halfLen);

			$newNumbersCount[$one] = ($newNumbersCount[$one] ?? 0) + $count;
			$newNumbersCount[$two] = ($newNumbersCount[$two] ?? 0) + $count;

			continue;
		}

		$newNumbersCount[$number * 2024] = $count;
	}

	$numbersCount = $newNumbersCount;
}

echo array_sum($numbersCount), "\n";
