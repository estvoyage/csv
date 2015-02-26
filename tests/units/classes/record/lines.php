<?php

namespace estvoyage\csv\tests\units\record;

require __DIR__ . '/../../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv\record,
	mock\estvoyage\csv as mockedCsv
;

class lines extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->implements('estvoyage\csv\record')
		;
	}

	function testUseSeparatorAndEolAndEscaper()
	{
		$this
			->given(
				$separator = new record\separator,
				$eol = new record\eol,
				$escaper = new record\escaper,

				$this->calling($record1 = new mockedCsv\record)
					->useSeparatorAndEolAndEscaper = $record1,

				$this->calling($record2 = new mockedCsv\record)
					->useSeparatorAndEolAndEscaper = $record2
			)

			->if(
				$this->newTestedInstance($record1, $record2)
			)
			->then
				->object($this->testedInstance->useSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($record1, $record2))
		;
	}
}
