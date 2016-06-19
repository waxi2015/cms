<?php

namespace Waxis\Cms\Cms\Filter;

class Date extends Ancestor {
	
	public $template = 'date.phtml';

	public function getFromValue () {
		$value = $this->getValue();
		
		if (!empty($value) && isset($value[0])) {
			return $value[0];
		}
	}

	public function getToValue () {
		$value = $this->getValue();
		
		if (!empty($value) && isset($value[1])) {
			return $value[1];
		}
	}
}