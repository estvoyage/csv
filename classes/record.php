<?php

namespace estvoyage\csv;

use
	estvoyage\data
;

interface record extends data\provider
{
	function useSeparatorAndEolAndEscaper(record\separator $separator, record\eol $eol, record\escaper $escaper);
	function dataConsumerIs(data\consumer $dataConsumer);
}
