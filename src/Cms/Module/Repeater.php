<?php

namespace Waxis\Cms\Cms\Module;

class Repeater extends Ancestor {

	public $type = 'list';

	public function setModule ($descriptor = null) {
		$descriptor = $descriptor !== null ? $descriptor : $this->descriptor;
		$page = isset($this->params['page']) ? $this->params['page'] : null;

		$this->module = new \Repeater($descriptor, $page);
	}
}