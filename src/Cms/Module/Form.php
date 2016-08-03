<?php

namespace Waxis\Cms\Cms\Module;

class Form extends Ancestor {

	public $type = 'form';

	public function setModule ($descriptor = null) {
		$descriptor = $descriptor !== null ? $descriptor : $this->descriptor;
		$data = null;

		if (isset($this->params['id'])) {
			$data = $this->params['id'];
		}

		if (isset($this->params['data'])) {
			$data = $this->params['data'];
		}

		if (is_string($descriptor)) {
			$descriptor = ucfirst($descriptor);

			if ($this->params['viewMode'] == true && class_exists('\App\Descriptors\Form\\' . $descriptor . '_view')) {
				$descriptor .= '_view';
			} elseif (class_exists('\App\Descriptors\Form\\' . $descriptor . '_' . strtolower($this->params['type']))) {
				$descriptor .= '_' . strtolower($this->params['type']);
			} elseif (!class_exists('\App\Descriptors\Form\\' . $descriptor)) {
				if (class_exists('\App\Descriptors\Form\\' . $descriptor . '_add')) {
					$descriptor .= '_add';
				}
			}	
		}

		$this->module = new \Form($descriptor, $data);
	}
}