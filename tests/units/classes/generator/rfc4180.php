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
					$csvGenerator->newCsvRecord(new csv\record(new csv\data('a'), new csv\data('b')));
				}
			)
			->then
				->object($this->testedInstance->forwardRecordFromProviderToDataConsumer($provider, $consumer))->isTestedInstance
				->mock($consumer)->receive('newData')->withArguments(new data\data('a,b' . "\r\n"))->once

			->if(
				$this->calling($provider)->useCsvGenerator = function($csvGenerator) {
					$csvGenerator
						->newCsvRecord(new csv\record(new csv\data('c'), new csv\data('d')))
						->newCsvRecord(new csv\record(new csv\data('e'), new csv\data('f')))
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
							new csv\record(new csv\data('g'), new csv\data('h')),
							new csv\record(new csv\data('i'), new csv\data('j'))
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
						->newCsvRecord(new csv\record(new csv\data('k,"l'), new csv\data('m,n'), new csv\data('o' . "\r\n" . 'p')));
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
