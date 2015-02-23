<?php

namespace estvoyage\csv;

final class data extends \estvoyage\value\string
{
	function __construct($value)
	{
		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception)
		{
			throw new exception\domain('Textdata should be a string');
		}
	}
}
