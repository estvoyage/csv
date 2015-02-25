<?php

namespace estvoyage\csv\record;

use
	estvoyage\csv\exception
;

final class maxSize extends \estvoyage\value\integer\unsigned
{
	function __construct($value)
	{
		$exception = null;

		try
		{
			parent::__construct($value);
		}
		catch (\exception $exception) {}

		if ($exception || ! self::isGreaterThanZero($value))
		{
			throw new exception\domain('Maximum record size should be greater than 0');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isGreaterThanZero($value);
	}

	private static function isGreaterThanZero($value)
	{
		return $value > 0;
	}
}
