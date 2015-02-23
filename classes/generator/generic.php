<?php

namespace estvoyage\csv\generator;

use
	estvoyage\csv,
	estvoyage\data
;

abstract class generic implements csv\generator
{
	private
		$consumer,
		$separator,
		$eol,
		$escaper
	;

	function __construct(separator $separator, eol $eol, escaper $escaper)
	{
		$this->separator = $separator;
		$this->eol = $eol;
		$this->escaper = $escaper;
	}

	function forwardRecordFromProviderToDataConsumer(csv\record\provider $provider, data\consumer $consumer)
	{
		$generator = $this->prepareToReceiveRecords();

		$generator->consumer = $consumer;

		$provider->useCsvGenerator($generator);

		return $this;
	}

	function newCsvRecord(csv\record $record)
	{
		return $this->process([ $record ]);
	}

	function newCsvRecords(csv\record... $records)
	{
		return $this->process($records);
	}

	protected abstract function prepareToReceiveRecords();

	private function process(array $records)
	{
		if ($this->consumer === null)
		{
			throw new exception\logic('Consumer is undefined');
		}

		$data = '';

		foreach ($records as $record)
		{
			$data .= $record->buildDataUsingSeparatorAndEolAndEscaper($this->separator, $this->eol, $this->escaper);
		}

		if ($data)
		{
			$this->consumer->newData(new data\data($data));
		}

		return $this;
	}
}
