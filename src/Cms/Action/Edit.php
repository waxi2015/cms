<?php

namespace Waxis\Cms\Cms\Action;

class Edit extends \Waxis\Cms\Cms\Action {

	public function execute () {
		# only set these actions if add is not an action
		# (to avoid duplications)
		if (!in_array('add', $this->actions) && $this->form !== null) {
			$this->addSaveButtonToForm();
			$this->addCancelButtonToForm();
			$this->addSaveToForm();
			$this->addIdFieldToForm();
			$this->addSuccessFeedbackToForm();
			$this->addErrorFeedbackToForm();
		}

		if ($this->list !== null) {
			$this->addEditButtonToList();
		}
	}
}