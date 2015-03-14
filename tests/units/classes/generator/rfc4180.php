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

	function testConstructor()
	{
		$this->object($this->newTestedInstance)->isEqualTo($this->newTestedInstance->dataConsumerIs(new data\consumer\blackhole));
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
					->isNotTestedInstance
					->isInstanceOf($this->testedInstance)
		;
	}

	function testNewCsvRecord()
	{
		$this
			->given(
				$dataConsumer = new mockOfData\consumer,
				$this->calling($record = new csv\record)
					->useSeparatorAndEolAndEscaper = $recordUsingRfc4180SeparatorEolAndEscaper = new csv\record
			)

			->if(
				$this->newTestedInstance($dataConsumer)
			)
			->then
				->object($this->testedInstance->newCsvRecord($record))->isTestedInstance
				->mock($record)
					->receive('useSeparatorAndEolAndEscaper')
						->withArguments(new record\separator, new record\eol, new record\escaper)
							->once
				->mock($recordUsingRfc4180SeparatorEolAndEscaper)
					->receive('dataConsumerIs')
						->withArguments($dataConsumer)
							->once
		;
	}
}
