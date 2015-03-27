<?php

namespace estvoyage\csv\record;

use
	estvoyage\data
;

interface template
{
	function newData(data\data... $data);
}
