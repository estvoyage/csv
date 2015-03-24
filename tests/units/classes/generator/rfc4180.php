<?php

namespace estvoyage\csv\tests\units\generator;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv\record,
	estvoyage\data,
	mock\estvoyage\csv as mockOfCsv,
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

	function testNewCsvRecord()
	{
		$this
			->given(
				$this->calling($record = new mockOfCsv\record)->useSeparatorAndEolAndEscaper = $recordWithSeparatorEolAndEscaper = new mockOfCsv\record
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newCsvRecord($record))->isTestedInstance
				->mock($record)
					->receive('useSeparatorAndEolAndEscaper')
						->withArguments(new record\separator, new record\eol, new record\escaper)
							->once
				->mock($recordWithSeparatorEolAndEscaper)
					->receive('dataConsumerIs')
						->withArguments(new data\data\buffer)
							->once
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
					->receive('dataProviderIs')
						->withArguments(new data\data\buffer)
							->once

			->given(
				$this->calling($record = new mockOfCsv\record)->useSeparatorAndEolAndEscaper = $recordWithSeparatorEolAndEscaper = new mockOfCsv\record,
				$this->calling($recordWithSeparatorEolAndEscaper)->dataConsumerIs = function($dataConsumer) use (& $recordData) {
					$dataConsumer->newData($recordData = new data\data(uniqid()));
				}
			)
			->if(
				$this->testedInstance
					->newCsvRecord($record)
						->dataConsumerIs($dataConsumer)
							->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($dataConsumer)
					->receive('dataProviderIs')
						->withArguments((new data\data\buffer)->newData($recordData))
							->once
		;
	}
}
