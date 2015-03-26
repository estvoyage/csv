<?php

namespace estvoyage\csv;

use
	estvoyage\data
;

interface record
{
	function newData(data\data $data);
	function csvRecordTemplateIs(record\template $template);
}
