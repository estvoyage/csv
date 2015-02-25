<?php

namespace estvoyage\csv\tests\units\exception;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units
;

class logic extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('logicException')
			->implements('estvoyage\csv\exception')
		;
	}
}
