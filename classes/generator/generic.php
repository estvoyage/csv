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
		$escaper,
		$recordMaxSize
	;

	function __construct(separator $separator, eol $eol, escaper $escaper, record\maxSize $recordMaxSize = null)
	{
		$this->separator = $separator;
		$this->eol = $eol;
		$this->escaper = $escaper;
		$this->recordMaxSize = $recordMaxSize;
	}

	function forwardRecordFromProviderToDataConsumer(csv\record\provider $provider, data\consumer $dataConsumer)
	{
		$this
			->prepareToReceiveRecords()
			->setConsumer($dataConsumer)
			->notifyRecordProvider($provider)
		;

		return $this;
	}

	function maxRecordSizeIs(record\maxSize $maxSize)
	{
		return $this->ifConsumer(function() use ($maxSize) {
				if ($this->recordMaxSize)
				{
					throw new exception\logic('Maximum record size is already defined');
				}

				$this->recordMaxSize = $maxSize;
			}
		);
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
		return $this->ifConsumer(function() use ($records) {
				$data = '';

				foreach ($records as $record)
				{
					$data .= $record->buildDataUsingSeparatorAndEolAndEscaper($this->separator, $this->eol, $this->escaper);
				}

				if ($data)
				{
					$this->dataConsumer->newData(new data\data($data));
				}
			}
		);
	}

	private function ifConsumer(callable $callable)
	{
		if ($this->dataConsumer === null)
		{
			throw new exception\logic('Consumer is undefined');
		}

		$callable();

		return $this;
	}

	private function setConsumer(data\consumer $dataConsumer)
	{
		$this->dataConsumer = $dataConsumer;

		return $this;
	}

	private function notifyRecordProvider(csv\record\provider $provider)
	{
		$provider->useCsvGenerator($this);

		return $this;
	}
}
