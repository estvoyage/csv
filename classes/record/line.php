<?php

namespace estvoyage\csv\record;

use
	estvoyage\data,
	estvoyage\csv,
	estvoyage\csv\record
;

final class line implements csv\record, data\provider
{
	private
		$data = [],
		$separator,
		$escaper,
		$eol
	;

	function __construct(data\data... $data)
	{
		$this->data = $data;
		$this->separator = new record\separator;
		$this->escaper = new record\escaper;
		$this->eol = new record\eol;
	}

	function useSeparatorAndEolAndEscaper(record\separator $separator, record\eol $eol, record\escaper $escaper)
	{
		$record = $this;

		switch (true)
		{
			case $separator != $this->separator:
			case $escaper != $this->escaper:
			case $eol != $this->eol:
				$record = new self;
				$record->data = $this->data;
				$record->separator = $separator;
				$record->eol = $eol;
				$record->escaper = $eol;
				break;
		}

		return $record;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		$separator = (string) $this->separator;
		$eol = (string) $this->eol;
		$escaper = (string) $this->escaper;

		for ($column = 0, $lastColumn = sizeof($this->data) - 1; $column <= $lastColumn; $column++)
		{
			$data = (string) $this->data[$column];

			switch (true)
			{
				case strpos($data, $eol) !== false:
				case strpos($data, $separator) !== false:
					if (strpos($data, $escaper) !== false)
					{
						$data = str_replace($escaper, $escaper . $escaper, $data);
					}

					$data = $escaper . $data . $escaper;
					break;
			}

			$dataConsumer->newData(new data\data($data . ($column < $lastColumn ? $separator : $eol)));
		}

		return $this;
	}
}
