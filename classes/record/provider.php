<?php

namespace estvoyage\csv\record;

use
	estvoyage\csv
;

interface provider
{
	function useCsvGenerator(csv\generator $generator);
}
