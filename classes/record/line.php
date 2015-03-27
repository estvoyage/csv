<?php

namespace estvoyage\csv\record;

use
	estvoyage\data,
	estvoyage\csv,
	estvoyage\csv\record
;

final class line implements csv\record
{
	private
		$data
	;

	function __construct(data\data... $data)
	{
		$this->data = $data ?: [];
	}

	function newData(data\data $data)
	{
		$line = clone $this;
		$line->data[] = $data;

		return $line;
	}

	function csvRecordTemplateIs(template $template)
	{
		$template->newData(... $this->data);

		return $this;
	}
}
