<?php

namespace estvoyage\csv\tests\units\generator;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv,
	estvoyage\data,
	mock\estvoyage\csv\record\provider as recordProvider,
	mock\estvoyage\data\consumer as dataConsumer
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

	function testNewCsvRecord()
	{
		$this
			->given(
				$record = new csv\record(new data\data('a'), new data\data('b'))
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->exception(function() use ($record) { $this->testedInstance->newCsvRecord($record); })
					->isInstanceOf('estvoyage\csv\exception\logic')
					->hasMessage('Consumer is undefined')
		;
	}

	function testNewCsvRecords()
	{
		$this
			->given(
				$record = new csv\record(new data\data('a'), new data\data('b'))
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->exception(function() use ($record) { $this->testedInstance->newCsvRecords($record); })
					->isInstanceOf('estvoyage\csv\exception\logic')
					->hasMessage('Consumer is undefined')
		;
	}

	function testForwardRecordFromProvideToDataConsumer()
	{
		$this
			->given(
				$provider = new recordProvider,
				$consumer = new dataConsumer,
				$this->newTestedInstance
			)

			->if(
				$this->calling($provider)->useCsvGenerator->doesNothing
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)->receive('newData')->never

			->if(
				$this->calling($provider)->useCsvGenerator = function($csvGenerator) {
					$csvGenerator->newCsvRecord(new csv\record(new data\data('a'), new data\data('b')));
				}
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)->receive('newData')->withArguments(new data\data('a,b' . "\r\n"))->once

			->if(
				$this->calling($provider)->useCsvGenerator = function($csvGenerator) {
					$csvGenerator
						->newCsvRecord(new csv\record(new data\data('c'), new data\data('d')))
						->newCsvRecord(new csv\record(new data\data('e'), new data\data('f')))
					;
				}
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)
					->receive('newData')
						->withArguments(new data\data('c,d' . "\r\n"))->once
						->withArguments(new data\data('e,f' . "\r\n"))->once

			->if(
				$this->calling($provider)->useCsvGenerator = function($csvGenerator) {
					$csvGenerator
						->newCsvRecords(
							new csv\record(new data\data('g'), new data\data('h')),
							new csv\record(new data\data('i'), new data\data('j'))
						)
					;
				}
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)
					->receive('newData')
						->withArguments(new data\data('g,h' . "\r\n" . 'i,j' . "\r\n"))->once

			->if(
				$this->calling($provider)->useCsvGenerator = function($csvGenerator) {
					$csvGenerator
						->newCsvRecord(new csv\record(new data\data('k,"l'), new data\data('m,n'), new data\data('o' . "\r\n" . 'p')));
					;
				}
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)
					->receive('newData')
						->withArguments(new data\data('"k,""l","m,n","o' . "\r\n" . 'p"' . "\r\n"))->once
		;
	}
}
