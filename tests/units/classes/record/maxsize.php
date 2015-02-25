<?php

namespace estvoyage\csv\tests\units\record;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv\record\maxSize as testedClass
;

class maxSize extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\value\integer\unsigned')
		;
	}

	function testConstructorWithZero()
	{
		$this->exception(function() { $this->newTestedInstance(0); })
			->isInstanceOf('estvoyage\csv\exception\domain')
			->hasMessage('Maximum record size should be greater than 0')
		;
	}

	function testValidateWithZero()
	{
		$this->boolean(testedClass::validate(0))->isFalse;
	}
}
