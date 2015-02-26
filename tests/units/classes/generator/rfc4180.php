<?php

namespace estvoyage\csv\tests\units\generator;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv\record,
	mock\estvoyage\csv,
	mock\estvoyage\data
;

class rfc4180 extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\csv\generator\generic')
		;
	}

	function testDataConsumerNeedCsvRecord()
	{
		$this
			->given(
				$dataConsumer = new data\consumer,
				$this->calling($record = new csv\record)
					->useSeparatorAndEolAndEscaper = $recordUsingRfc4180SeparatorEolAndEscaper = new csv\record
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->dataConsumerNeedCsvRecord($dataConsumer, $record))->isTestedInstance
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
