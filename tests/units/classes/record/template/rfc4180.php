<?php

namespace estvoyage\csv\tests\units\record\template;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\data,
	estvoyage\csv\record,
	mock\estvoyage\csv as mockOfCsv,
	mock\estvoyage\data as mockOfData
;

class rfc4180 extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\csv\record\template\generic')
		;
	}

	function testNewCsvRecord()
	{
		$this
			->given(
				$record = new mockOfCsv\record
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newCsvRecord($record))->isTestedInstance
				->mock($record)
					->receive('csvRecordTemplateIs')
						->withArguments($this->testedInstance)
							->once
		;
	}

	function testDataConsumerIs()
	{
		$this
			->given(
				$separator = new record\separator,
				$escaper = new record\escaper,
				$eol = new record\eol,
				$dataConsumer = new mockOfData\consumer
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))->isTestedInstance
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data)
							->once

			->given(
				$data1 = new data\data(uniqid()),
				$data2 = new data\data(uniqid()),
				$data3 = new data\data(uniqid())
			)
			->if(
				$this->testedInstance
					->newData($data1, $data2, $data3)
						->dataConsumerIs($dataConsumer)
							->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data($data1 . $separator . $data2 . $separator . $data3 . $eol))
							->once

			->given(
				$dataWithSeparator = new data\data(uniqid() . $separator . uniqid())
			)
			->if(
				$this->testedInstance
					->newData($data1, $dataWithSeparator, $data3)
						->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data($data1 . $separator . $escaper . $dataWithSeparator . $escaper . $separator . $data3 . $eol))
							->once

			->given(
				$dataWithEol = new data\data(uniqid() . $eol . uniqid())
			)
			->if(
				$this->testedInstance
					->newData($data1, $dataWithEol, $data3)
						->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data($data1 . $separator . $escaper . $dataWithEol . $escaper . $separator . $data3 . $eol))
							->once

			->given(
				$dataWithSeparatorAndEscaper = new data\data(($dataBeforeEscaper = new data\data(uniqid())) . $escaper . ($dataBetweenEscaperAndSeparator = new data\data(uniqid())) . $separator . ($dataAfterSeparator = uniqid()))
			)
			->if(
				$this->testedInstance
					->newData($data1, $dataWithSeparatorAndEscaper, $data3)
						->dataConsumerIs($dataConsumer)
			)
			->then
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data($data1 . $separator . $escaper . $dataBeforeEscaper . $escaper . $escaper . $dataBetweenEscaperAndSeparator . $separator . $dataAfterSeparator . $escaper . $separator . $data3 . $eol))
							->once
		;
	}
}
