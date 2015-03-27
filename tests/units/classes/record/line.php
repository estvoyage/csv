<?php

namespace estvoyage\csv\tests\units\record;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv,
	estvoyage\data,
	mock\estvoyage\csv as mockOfCsv,
	mock\estvoyage\data as mockOfData
;

class line extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->implements('estvoyage\csv\record')
		;
	}

	function testNewData()
	{
		$this
			->given(
				$data = new data\data
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newData($data))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($data))
		;
	}

	function testCsvRecordTemplateIs()
	{
		$this
			->given(
				$data1 = new data\data(uniqid()),
				$data2 = new data\data(uniqid()),
				$data3 = new data\data(uniqid()),
				$csvRecordTemplate = new mockOfCsv\record\template
			)
			->if(
				$this->calling($csvRecordTemplate)->newData = function($data) use (& $record) { $record .= $data; },
				$this->calling($csvRecordTemplate)->noMoreData = function() use (& $record) { $record .= PHP_EOL; },
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->csvRecordTemplateIs($csvRecordTemplate))->isTestedInstance
				->mock($csvRecordTemplate)
					->didNotReceiveAnyMessage

			->if(
				$this->testedInstance
					->newData($data1)
					->newData($data2)
					->newData($data3)
						->csvRecordTemplateIs($csvRecordTemplate)
			)
			->then
				->string($record)->isEqualTo($data1 . $data2 . $data3 . PHP_EOL)
		;
	}
}
