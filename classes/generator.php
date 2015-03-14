<?php

namespace estvoyage\csv;

use
	estvoyage\data
;

interface generator extends data\provider
{
	function newCsvRecord(record $record);
}
