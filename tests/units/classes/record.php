<?php

namespace estvoyage\csv\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\csv\tests\units,
	estvoyage\csv,
	estvoyage\data
;

class record extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
		;
	}

	function testBuildDataUsingSeparatorAndEolAndEscaper()
	{
		$this
			->given(
				$separator = new csv\generator\separator(','),
				$eol = new csv\generator\eol("\r\n"),
				$escaper = new csv\generator\escaper('"'),
				$data1 = new data\data(uniqid()),
				$data2 = new data\data(uniqid()),
				$dataWithEol = new data\data(uniqid() . $eol . uniqid()),
				$dataWithEolAndEscaper = new data\data('a' . $eol . 'b' . $escaper . 'c'),
				$dataWithSeparator = new data\data(uniqid() . $separator . uniqid()),
				$dataWithSeparatorAndEscaper = new data\data('a' . $separator . 'b' . $escaper . 'c')
			)

			->if(
				$this->newTestedInstance($data1)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $eol))

			->if(
				$this->newTestedInstance($data1, $data2)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $separator . $data2 . $eol))

			->if(
				$this->newTestedInstance($data1, $dataWithEol, $data2)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $separator . $escaper . $dataWithEol . $escaper . $separator . $data2 . $eol))

			->if(
				$this->newTestedInstance($data1, $dataWithEolAndEscaper, $data2)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $separator . $escaper . 'a' . $eol . 'b' . $escaper . $escaper . 'c' . $escaper . $separator . $data2 . $eol))

			->if(
				$this->newTestedInstance($data1, $dataWithSeparator, $data2)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $separator . $escaper . $dataWithSeparator . $escaper . $separator . $data2 . $eol))

			->if(
				$this->newTestedInstance($data1, $dataWithSeparatorAndEscaper, $data2)
			)
			->then
				->object($this->testedInstance->buildDataUsingSeparatorAndEolAndEscaper($separator, $eol, $escaper))
					->isEqualTo(new data\data($data1 . $separator . $escaper . 'a' . $separator . 'b' . $escaper . $escaper . 'c' . $escaper . $separator . $data2 . $eol))
		;
	}
}
