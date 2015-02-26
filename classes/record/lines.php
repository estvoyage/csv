<?php

namespace estvoyage\csv\record;

use
	estvoyage\data,
	estvoyage\csv\record
;

final class lines implements record
{
	private
		$records
	;

	function __construct(record... $records)
	{
		$this->records = $records;
	}

	function useSeparatorAndEolAndEscaper(record\separator $separator, record\eol $eol, record\escaper $escaper)
	{
		$lines = new self;

		foreach ($this->records as $record)
		{
			$lines->records[] = $record->useSeparatorAndEolAndEscaper($separator, $eol, $escaper);
		}

		return $lines;
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
