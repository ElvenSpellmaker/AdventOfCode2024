<?php

$drive = rtrim(file_get_contents('d9.txt'));

$driveMap = [];

$id = 0;
for ($i = 0, $drivePos = 0; $i < strlen($drive); $i++)
{
	if ($i % 2 === 0)
	{
		$file = $drive[$i];
		while ($file--)
		{
			$driveMap[$drivePos++] = $id;
		}

		$id++;

		continue;
	}

	$drivePos += $drive[$i];
}

$sum = 0;

$freePos = 0;
$dmCount = count($driveMap);
while ($freePos !== $dmCount)
{
	$filePart = array_pop($driveMap);

	while (isset($driveMap[$freePos]))
	{
		$sum += $freePos * $driveMap[$freePos];
		$freePos++;
	}

	$sum += $freePos++ * $filePart;
}

echo $sum, "\n";
