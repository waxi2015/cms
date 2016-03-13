<?php

namespace Waxis\Cms\Cms\Action;

class Multilingual extends \Waxis\Cms\Cms\Action {

	public function execute () {
		if ($this->list !== null) {
			$this->addMultilingualWhereToList();
		}

		if ($this->form !== null) {
			$this->addMultilingualToForm();
		}
	}
}