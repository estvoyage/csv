<?php

namespace estvoyage\csv\record;

use
	estvoyage\csv
;

final class eol extends \estvoyage\value\string
{
	function __construct($value = "\r\n")
	{
		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception)
		{
			throw new csv\exception\domain('End-of-line should be a string');
		}
	}
}
