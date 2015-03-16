<?php

namespace estvoyage\csv\generator;

use
	estvoyage\data,
	estvoyage\csv\record,
	estvoyage\csv\generator
;

final class rfc4180 extends generator\generic
{
	private static
		$eol,
		$separator,
		$escaper
	;

	function __construct()
	{
		parent::__construct(
			self::$separator ?: (self::$separator = new record\separator),
			self::$eol ?: (self::$eol = new record\eol),
			self::$escaper ?: (self::$escaper = new record\escaper)
		);
	}
}
