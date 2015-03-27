<?php

namespace estvoyage\csv\record;

use
	estvoyage\data,
	estvoyage\csv,
	estvoyage\csv\record
;

final class line implements csv\record
{
	private
		$data = [],
		$separator,
		$escaper,
		$eol
	;

	private static
		$defaultSeparator,
		$defaultEscaper,
		$defaultEol
	;

	function __construct(data\data... $data)
	{
		$this->data = $data;
		$this->separator = self::$defaultSeparator ?: (self::$defaultSeparator = new record\separator);
		$this->escaper = self::$defaultEscaper ?: (self::$defaultEscaper = new record\escaper);
		$this->eol = self::$defaultEol ?: (self::$defaultEol = new record\eol);
	}

	function newData(data\data $data)
	{
		$line = clone $this;
		$line->data[] = $data;

		return $line;
	}

	function csvRecordTemplateIs(template $template)
	{
		if ($this->data)
		{
			foreach ($this->data as $data)
			{
				$template->newData($data);
			}

			$template->noMoreData();
		}

		return $this;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		$separator = (string) $this->separator;
		$eol = (string) $this->eol;
		$escaper = (string) $this->escaper;
		$data = '';

		for ($column = 0, $lastColumn = sizeof($this->data) - 1; $column <= $lastColumn; $column++)
		{
			$columnValue = (string) $this->data[$column];

			switch (true)
			{
				case strpos($columnValue, $eol) !== false:
				case strpos($columnValue, $separator) !== false:
					if (strpos($columnValue, $escaper) !== false)
					{
						$columnValue = str_replace($escaper, $escaper . $escaper, $columnValue);
					}

					$columnValue = $escaper . $columnValue . $escaper;
			}

			$data .= $columnValue . ($column < $lastColumn ? $separator : $eol);
		}

		$dataConsumer->newData(new data\data($data));

		return $this;
	}
}
