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

	function dataConsumerNeedCsvRecord(data\consumer $dataConsumer, csv\record $record)
	{
		$record
			->useSeparatorAndEolAndEscaper(
				$this->separator,
				$this->eol,
				$this->escaper
			)
				->dataConsumerIs($dataConsumer)
		;

		return $this;
	}
}
