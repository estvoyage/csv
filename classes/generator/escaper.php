<?php

namespace estvoyage\csv\generator;

use
	estvoyage\csv
;

final class escaper extends \estvoyage\value\string
{
	function __construct($value)
	{
		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception)
		{
			throw new csv\exception\domain('Escaper should be a string');
		}
	}
}
