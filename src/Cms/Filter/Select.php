<?php

namespace Waxis\Cms\Cms\Filter;

class Select extends Ancestor {
	
	public $template = 'select.phtml';

	public $source = null;

	public function __construct ($descriptor) {
		$this->source = $descriptor['source'];

		parent::__construct($descriptor);
	}

	public function getOptions () {
		$source = $this->getSource();

		if (isset($source['table'])) {
			$source = $this->getSourceFromDb();
		}

		$source = array('' => $this->placeholder) + $source;

		return $source;
	}

	public function getSourceFromDb () {
		$source = $this->getSource();

		# @todo: check
		$results = DB::table($source['table'])->get()->toArray();

		$temp = array();

		foreach ($results as $one) {
			$temp[$one[$source['key']]] = $one[$source['value']];
		}

		return $temp;
	}

	public function getSource () {
		return $this->source;
	}
}