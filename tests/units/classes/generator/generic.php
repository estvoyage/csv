<?php

namespace estvoyage\csv\tests\units\generator;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units
;

class generic extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->implements('estvoyage\csv\generator')
		;
	}
}
