<?php

namespace estvoyage\csv\record\template;

use
	estvoyage\csv,
	estvoyage\data
;

abstract class generic implements data\provider, csv\record\template
{
	private
		$data,
		$separator,
		$escaper,
		$eol
	;

	function __construct(csv\record\separator $separator, csv\record\escaper $escaper, csv\record\eol $eol)
	{
		$this->data = '';
		$this->separator = (string) $separator;
		$this->escaper = (string) $escaper;
		$this->eol = (string) $eol;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		$dataConsumer->newData(new data\data($this->data));

		$this->data = '';

		return $this;
	}

	function newCsvRecord(csv\record $record)
	{
		$record->csvRecordTemplateIs($this);

		return $this;
	}

	function newData(data\data... $columns)
	{
		foreach ($columns as $column)
		{
			$column = (string) $column;

			switch (true)
			{
				case strpos($column, $this->eol) !== false:
				case strpos($column, $this->separator) !== false:
					if (strpos($column, $this->escaper) !== false)
					{
						$column = str_replace($this->escaper, $this->escaper . $this->escaper, $column);
					}

					$column = $this->escaper . $column . $this->escaper;
			}

			$this->data .= (! $this->data ? '' : $this->separator) . $column;
		}

		if ($this->data)
		{
			$this->data .= $this->eol;
		}

		return $this;
	}
}
