<?php

namespace estvoyage\csv\generator;

use
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
			self::$separator ?: (self::$separator = new generator\separator(',')),
			self::$eol ?: (self::$eol = new generator\eol("\r\n")),
			self::$escaper ?: (self::$escaper = new generator\escaper('"'))
		);
	}

	function prepareToReceiveRecords()
	{
		return new self;
	}
}
