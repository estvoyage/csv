<?php

namespace estvoyage\csv;

final class record
{
	private
		$data = []
	;

	function __construct(data $firstData, data... $data)
	{
		array_unshift($data, $firstData);

		$this->data = $data;
	}

	function buildDataUsingSeparatorAndEolAndEscaper(generator\separator $separator, generator\eol $eol, generator\escaper $escaper)
	{
		$data = [];

		$separator = (string) $separator;
		$eol = (string) $eol;
		$escaper = (string) $escaper;

		foreach ($this->data as $textdata)
		{
			$textdata = (string) $textdata;

			switch (true)
			{
				case strpos($textdata, $eol) !== false:
				case strpos($textdata, $separator) !== false:
					if (strpos($textdata, $escaper) !== false)
					{
						$textdata = str_replace($escaper, $escaper . $escaper, $textdata);
					}

					$textdata = $escaper . $textdata . $escaper;
					break;
			}

			$data[] = $textdata;
		}

		return new \estvoyage\data\data(join($separator, $data) . $eol);
	}
}
