<?php

$drive = rtrim(file_get_contents('d9.txt'));

$driveMap = [];
$freeMap = [];
$freeMapCount = [];

$id = 0;
for ($i = 0, $drivePos = 0; $i < strlen($drive); $i++)
{
	$file = $drive[$i];

	if ($i % 2 === 0)
	{
		while ($file--)
		{
			$driveMap[$drivePos] = $id;
			$driveMapById[$id][] = $drivePos++;
		}

		$id++;

		continue;
	}

	$freePos = [];

	while ($file--)
	{
		$freePos[] = $drivePos++;
	}

	$freePosCount = count($freePos);
	if ($freePosCount)
	{
		$freeMap[] = $freePos;
		$freeMapCount[] = $freePosCount;
	}
}

$sum = 0;

while (count($driveMapById))
{
	$id = array_key_last($driveMapById);
	$drivePosses = array_pop($driveMapById);
	$drivePossesCount = count($drivePosses);

	foreach ($freeMap as $i => $freeSpace)
	{
		if ($freeMap[$i][0] > $drivePosses[0])
		{
			break;
		}

		if ($freeMapCount[$i] < $drivePossesCount)
		{
			continue;
		}

		while ($drivePossesCount--)
		{
			$sum += $id * array_shift($freeMap[$i]);
			$freeMapCount[$i]--;
		}

		if ($freeMapCount[$i] === 0)
		{
			unset($freeMap[$i]);
			unset($freeMapCount[$i]);
		}

		continue 2;
	}

	foreach ($drivePosses as $drivePos)
	{
		$sum += $id * $drivePos;
	}
}

echo $sum, "\n";
