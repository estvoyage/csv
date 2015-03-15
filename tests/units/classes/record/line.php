<?php

namespace estvoyage\csv\tests\units\record;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv,
	estvoyage\data,
	mock\estvoyage\data as mockedData
;

class line extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->implements('estvoyage\csv\record')
			->implements('estvoyage\data\provider')
		;
	}

	function testNewData()
	{
		$this
			->given(
				$data = new data\data,
				$separator = new csv\record\separator(uniqid()),
				$escaper = new csv\record\escaper(uniqid()),
				$eol = new csv\record\eol(uniqid())
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->newData($data))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($data))

				->object(
					$this->newTestedInstance($data)
						->useSeparatorAndEolAndEscaper($separator, $eol, $escaper)
							->newData($data)
				)
					->isEqualTo(
						$this->newTestedInstance($data, $data)
							->useSeparatorAndEolAndEscaper($separator, $eol, $escaper)
					)
		;
	}

	function testUseSeparatorAndEolAndEscaper()
	{
		$this
			->given(
				$defaultSeparator = new csv\record\separator,
				$separator = new csv\record\separator(uniqid()),
				$defaultEscaper = new csv\record\escaper,
				$escaper = new csv\record\escaper(uniqid()),
				$defaultEol = new csv\record\eol,
				$eol = new csv\record\eol(uniqid())
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->useSeparatorAndEolAndEscaper($defaultSeparator, $defaultEol, $defaultEscaper))->isTestedInstance

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->useSeparatorAndEolAndEscaper($separator, $defaultEol, $defaultEscaper))
					->isNotTestedInstance
					->isInstanceOf($this->testedInstance)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->useSeparatorAndEolAndEscaper($defaultSeparator, $eol, $defaultEscaper))
					->isNotTestedInstance
					->isInstanceOf($this->testedInstance)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->useSeparatorAndEolAndEscaper($defaultSeparator, $defaultEol, $escaper))
					->isNotTestedInstance
					->isInstanceOf($this->testedInstance)
		;
	}

	function testDataConsumerIs()
	{
		$this
			->given(
				$defaultSeparator = new csv\record\separator,
				$separator = new csv\record\separator(uniqid()),
				$defaultEscaper = new csv\record\escaper,
				$escaper = new csv\record\escaper(uniqid()),
				$defaultEol = new csv\record\eol,
				$eol = new csv\record\eol(uniqid()),
				$this->calling($dataConsumer = new mockedData\consumer)
					->newData = function($data)
						use (& $dataReceived) {
							$dataReceived .= $data;
						}
			)

			->if(
				$dataReceived = '',
				$this->newTestedInstance(new data\data('a'))
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))
					->isTestedInstance
				->string($dataReceived)->isEqualTo('a' . $defaultEol)

			->if(
				$dataReceived = '',
				$this->newTestedInstance(new data\data('a'), new data\data('b'))
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))
					->isTestedInstance
				->string($dataReceived)->isEqualTo('a' . $defaultSeparator . 'b' . $defaultEol)

			->if(
				$dataReceived = '',
				$this->newTestedInstance(new data\data('a b'), new data\data('c d'))
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))
					->isTestedInstance
				->string($dataReceived)->isEqualTo('a b' . $defaultSeparator . 'c d' . $defaultEol)

			->if(
				$dataReceived = '',
				$this->newTestedInstance(new data\data('a' . $defaultSeparator . 'b'), new data\data('c' . $defaultEol . 'd'), new data\data('e' . $defaultSeparator . $defaultEscaper . 'f'))
			)
			->then
				->object($this->testedInstance->dataConsumerIs($dataConsumer))
					->isTestedInstance
				->string($dataReceived)->isEqualTo('"a' . $defaultSeparator . 'b"' . $defaultSeparator . '"c' . $defaultEol . 'd"' . $defaultSeparator . $defaultEscaper . 'e' . $defaultSeparator . $defaultEscaper . $defaultEscaper . 'f' . $defaultEscaper . $defaultEol)

			->if(
				$dataReceived = '',
				$this->testedInstance->useSeparatorAndEolAndEscaper($separator, $eol, $escaper)->dataConsumerIs($dataConsumer)
			)
			->then
				->string($dataReceived)->isEqualTo('a' . $defaultSeparator . 'b' . $separator . 'c' . $defaultEol . 'd' . $separator . 'e' . $defaultSeparator . $defaultEscaper . 'f' . $eol)
		;
	}
}
