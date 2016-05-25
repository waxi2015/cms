<?php

namespace Waxis\Cms\Cms\Action;

class Delete extends \Waxis\Cms\Cms\Action {

	public function execute () {
		if ($this->list !== null) {
			$this->addDeleteButtonToList();
		}
	}
}