<?php

namespace Waxis\Cms\Cms\Filter;

class Select extends Ancestor {
	
	public $template = 'select.phtml';

	public $source = null;

	public function __construct ($descriptor) {
		$this->source = $descriptor['source'];

		if (isset($this->source['order'])) {
			$this->order = $this->source['order'];
		}

		if (isset($this->source['by'])) {
			$this->by = $this->source['by'];
		}

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
		$results = to_array(\DB::table($source['table'])->orderBy($this->getBy(), $this->getOrder())->get());

		$temp = array();

		foreach ($results as $one) {
			$temp[$one[$source['key']]] = $one[$source['value']];
		}

		return $temp;
	}

	public function getSource () {
		$source = $this->source;

		if (isset($source['class']) && isset($source['method'])) {
			$sourceClass = $source['class'];
			$sourceMethod = $source['method'];
			$source = new $sourceClass;
			$source = $source->$sourceMethod();
		}

		if (!is_array($source) && strstr($source, '::')){
			$source = explode('::',$source);
			$sourceClass = $source[0];
			$sourceMethod = $source[1];
			$source = call_user_func($sourceClass . '::' . $sourceMethod);
		}

		return $source;
	}

	public function getOrder () {
		return $this->order;
	}

	public function getBy () {
		return $this->by;
	}
}