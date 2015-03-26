<?php

namespace estvoyage\csv\generator;

use
	estvoyage\csv,
	estvoyage\data,
	estvoyage\csv\record,
	estvoyage\csv\exception
;

abstract class generic implements csv\generator
{
	private
		$template
	;

	function __construct(record\template $template)
	{
		$this->template = $template;
	}

	function newCsvRecord(csv\record $record)
	{
		$record->csvRecordTemplateIs($this->template);

		return $this;
	}

	function dataConsumerIs(data\consumer $dataConsumer)
	{
		$dataConsumer->dataProviderIs($this->template);

		return $this;
	}
}
