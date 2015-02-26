<?php

namespace estvoyage\csv;

use
	estvoyage\data
;

interface generator
{
	function dataConsumerNeedCsvRecord(data\consumer $dataConsumer, record $record);
}
