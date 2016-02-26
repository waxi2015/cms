<?php

namespace Waxis\Cms\Cms\Action;

class Order extends \Waxis\Cms\Cms\Action {

	public $hasOrderColumn = false;

	public $orderField = 'order';

	public $orderParams = null;

	public function __construct (&$cms) {
		parent::__construct($cms);
		
		# figure out if the list has order already
		# if it does get it's order params (dependency from other fields)
		foreach ($this->listDescriptor['fields'] as $field) {
			if (isset($field['type']) && $field['type'] == 'order') {
				$this->hasOrderColumn = true;
				$this->orderField = $field['name'];

				if (isset($field['options']) && isset($field['options']['params'])) {
					$this->orderParams = $field['options']['params'];
				}
			}
		}
	}

	public function execute () {
		if (!$this->form !== null) {
			$this->addAddOrderAfterSaveToForm();
			$this->addCorrectOrderBeforeSaveToForm();
		}

		if (!$this->list !== null) {
			$this->addDefaultOrderToList();
			$this->addOrderColumnToList();
		}
	}
}