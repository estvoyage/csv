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
				$csvRecord = new mockOfCsv\record
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newCsvRecord($csvRecord))->isTestedInstance
				->mock($csvRecord)
					->receive('csvRecordTemplateIs')
						->withArguments(new record\template\rfc4180)
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
						->withArguments(new record\template\rfc4180)
							->once
		;
	}
}
