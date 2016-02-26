<?php

namespace Waxis\Cms\Cms\Action;

class Filter extends \Waxis\Cms\Cms\Action {

	public function execute () {
		if ($this->list !== null) {
			$this->addFiltersToList();
		}
	}
}