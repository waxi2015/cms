<?php

namespace Waxis\Cms\Cms\Action;

class Edit extends \Waxis\Cms\Cms\Action {

	public function execute () {
		# only set these actions if add is not an action
		# (to avoid duplications)
		if (!in_array('add', $this->actions) && $this->form !== null) {
			$this->addCancelButtonToForm();
			$this->addSaveButtonToForm();
			$this->addSaveToForm();
			$this->addIdFieldToForm();
			$this->addHandleImageBeforeSaveToForm();
			$this->addHandleMultiimageBeforeSaveToForm();
			$this->addSuccessFeedbackToForm();
		}

		if ($this->list !== null) {
			$this->addEditButtonToList();
		}

		if ($this->contentDescriptor !== null) {
			$this->addSaveButtonToContent();
			$this->addCancelButtonToContent();
		}
	}
}