<?php

$stones = new SplDoublyLinkedList;

$numbers = array_map(fn(int $stone) => $stones->push($stone), explode(' ', rtrim(file_get_contents('d11.txt'))));

$rounds = 25;

while ($rounds--)
{
	foreach ($stones as $pos => $stone)
	{
		if ($stone === 0)
		{
			$stones->offsetUnset($insPos);
			$stones->add($insPos, 1);

			$insPos++;

			continue;
		}

		$stoneLen = strlen($stone);

		if ($stoneLen % 2 === 0)
		{
			$halfLen = $stoneLen / 2;
			$stones->offsetUnset($insPos);

			$one = substr($stone, 0, $halfLen);
			$two = substr($stone, $halfLen);

			$stones->add($insPos, (int)$one);
			$stones->add($insPos + 1, (int)$two);

			$insPos += 2;

			continue;
		}

		$stones->offsetUnset($insPos);
		$stones->add($insPos, $stone * 2024);

		$insPos++;
	}
}

echo count($stones), "\n";
