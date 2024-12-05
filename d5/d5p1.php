<?php



[$rules, $manuals] = array_map(fn(string $s) => explode("\n", $s), explode("\n\n", rtrim(file_get_contents('d5.txt'))));

class SafetyHeap extends SplHeap
{
	public static array $rules = [];

	public function compare(mixed $value1, mixed $value2) : int
	{
		if ($value1 === $value2)
		{
			return 0;
		}

		if (isset(self::$rules[$value1][$value2]))
		{
			return -1;
		}

		if (isset(self::$rules[$value2][$value1]))
		{
			return 1;
		}

		throw new RuntimeException('Value is not in the $rules!');
	}
}

$rules = array_map(fn(string $s) => explode('|', $s), $rules);

foreach ($rules as [$before, $after])
{
	SafetyHeap::$rules[$before][$after] = true;
}

$manuals = array_map(fn(string $s) => explode(',', $s), $manuals);

$sum = 0;

foreach ($manuals as $manual)
{
	$heap = new SafetyHeap;
	foreach ($manual as $page)
	{
		$heap->insert($page);
	}

	$pages = iterator_to_array($heap);

	foreach ($pages as $i => $page)
	{
		if ($page != $manual[$i])
		{
			continue 2;
		}
	}

	$middlePage = $pages[(count($pages) - 1) / 2];

	$sum += $middlePage;
}

echo $sum, "\n";
