<?php

namespace estvoyage\csv\tests\units\exception;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units
;

class domain extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('domainException')
			->implements('estvoyage\csv\exception')
		;
	}
}
