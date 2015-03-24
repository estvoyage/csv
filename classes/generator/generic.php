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
		$buffer,
		$separator,
		$eol,
		$escaper
	;

	function __construct(record\separator $separator, record\eol $eol, record\escaper $escaper)
	{
		$this->buffer = new data\data\buffer;
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
			->dataConsumerIs($this->buffer)
		;

		return $this;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		$dataConsumer->dataProviderIs($this->buffer);

		$this->buffer = new data\data\buffer;

		return $this;
	}
}
