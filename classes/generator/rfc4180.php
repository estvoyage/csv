<?php

namespace estvoyage\csv\generator;

use
	estvoyage\data,
	estvoyage\csv\record,
	estvoyage\csv\generator
;

final class rfc4180 extends generator\generic
{
	function __construct()
	{
		parent::__construct(new record\template\rfc4180);
	}
}
