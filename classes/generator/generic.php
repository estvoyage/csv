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
		$dataConsumer,
		$separator,
		$eol,
		$escaper
	;

	function __construct(record\separator $separator, record\eol $eol, record\escaper $escaper, data\consumer $dataConsumer = null)
	{
		$this->dataConsumer = $dataConsumer ?: new data\consumer\blackhole;
		$this->separator = $separator;
		$this->eol = $eol;
		$this->escaper = $escaper;
	}

	function newCsvRecord(csv\record $record)
	{
		$record
			->useSeparatorAndEolAndEscaper(
				$this->separator,
				$this->eol,
				$this->escaper
			)
				->dataConsumerIs($this->dataConsumer)
		;

		return $this;
	}
}
