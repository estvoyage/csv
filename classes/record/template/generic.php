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

		$this->data .= $this->eol;

		return $this;
	}

	function newData(data\data $data)
	{
		switch (true)
		{
			case strpos($data, $this->eol) !== false:
			case strpos($data, $this->separator) !== false:
				if (strpos($data, $this->escaper) !== false)
				{
					$data = str_replace($this->escaper, $this->escaper . $this->escaper, $data);
				}

				$data = $this->escaper . $data . $this->escaper;
		}

		$this->data .= (! $this->data ? '' : $this->separator) . $data;

		return $this;
	}
}
