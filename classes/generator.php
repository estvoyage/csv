<?php

namespace estvoyage\csv;

use
	estvoyage\data
;

interface generator
{
	function forwardRecordFromProviderToDataConsumer(record\provider $provider, data\consumer $consumer);
	function maxRecordSizeIs(record\maxSize $maxSize);
	function newCsvRecord(record $record);
	function newCsvRecords(record... $records);
}
