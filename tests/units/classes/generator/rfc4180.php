<?php

namespace estvoyage\csv\tests\units\generator;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv\record,
	estvoyage\data,
	mock\estvoyage\csv,
	mock\estvoyage\data as mockOfData
;

class rfc4180 extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->implements('estvoyage\csv\generator')
		;
	}

	function testDataConsumerIs()
	{
		$this
			->given(
				$dataConsumer = new mockOfData\consumer
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))
					->isTestedInstance
				->mock($dataConsumer)
					->didNotReceiveAnyMessage()

			->given(
				$this->calling($record = new csv\record)->useSeparatorAndEolAndEscaper = $record
			)
			->if(
				$this->testedInstance->newCsvRecord($record)->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($record)
					->receive('dataConsumerIs')
						->withIdenticalArguments($dataConsumer)
							->once
		;
	}

	function testNewCsvRecord()
	{
		$this
			->given(
				$record = new csv\record
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newCsvRecord($record))
					->isNotTestedInstance
					->isInstanceOf($this->testedInstance)
				->mock($record)
					->receive('useSeparatorAndEolAndEscaper')
						->withArguments(new record\separator, new record\eol, new record\escaper)
							->once
		;
	}
}
