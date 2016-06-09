<?php

namespace Waxis\Cms\Cms\Action;

class Add extends \Waxis\Cms\Cms\Action {

	public function execute () {
		if ($this->list !== null) {
			$this->addAddButtonToList();
		}

		if ($this->form !== null) {
			$this->addSaveButtonToForm();
			$this->addCancelButtonToForm();
			$this->addAddNewButtonToForm();
			$this->addSaveToForm();
			$this->addIdFieldToForm();
			$this->addSuccessFeedbackToForm();
			$this->addErrorFeedbackToForm();
			$this->addCreatedAtFieldToAddForm();
		}
	}
}