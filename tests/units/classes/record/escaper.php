<?php

namespace estvoyage\csv\tests\units\record;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units
;

class escaper extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\value\string')
		;
	}

	function testConstructorWithoutArgument()
	{
		$this->castToString($this->newTestedInstance)->isEqualTo('"');
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($invalidValue)
	{
		$this->exception(function() use ($invalidValue) { $this->newTestedInstance($invalidValue); })
			->isInstanceOf('estvoyage\csv\exception\domain')
			->hasMessage('Escaper should be a string')
		;
	}

	protected function invalidValueProvider()
	{
		return [
			rand(- PHP_INT_MAX, PHP_INT_MAX)
		];
	}
}
