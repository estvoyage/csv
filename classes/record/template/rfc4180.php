<?php

namespace estvoyage\csv\record\template;

use
	estvoyage\csv\record
;

final class rfc4180 extends generic
{
	function __construct()
	{
		parent::__construct(new record\separator, new record\escaper, new record\eol);
	}
}
