<?php

namespace estvoyage\csv\generator;

use
	estvoyage\csv,
	estvoyage\data,
	estvoyage\csv\record,
	estvoyage\csv\exception
;

abstract class generic implements csv\generator
{
	private
		$records = [],
		$separator,
		$eol,
		$escaper
	;

	function __construct(record\separator $separator, record\eol $eol, record\escaper $escaper)
	{
		$this->separator = $separator;
		$this->eol = $eol;
		$this->escaper = $escaper;
	}

	function newCsvRecord(csv\record $record)
	{
		$csv = clone $this;
		$csv->records[] = $record
			->useSeparatorAndEolAndEscaper(
				$this->separator,
				$this->eol,
				$this->escaper
			)
		;

		return $csv;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		foreach ($this->records as $record)
		{
			$record->dataConsumerIs($dataConsumer);
		}

		return $this;
	}
}
