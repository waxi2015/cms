<?php

namespace Waxis\Cms\Cms\Module;

class Repeater extends Ancestor {

	public $type = 'list';

	public function setModule ($descriptor = null) {
		$descriptor = $descriptor !== null ? $descriptor : $this->descriptor;
		$page = isset($this->params['page']) ? $this->params['page'] : null;
		$params = [];

		if (isset($_COOKIE[$descriptor['id'] . '-filters'])) {
			$filters = json_decode($_COOKIE[$descriptor['id'] . '-filters'], true);

			$params['filters'] = [];
			foreach ($filters as $key => $value) {
				if ($value != '') {
					if (preg_match('(\[[0-9]+\])', $key, $keys) != 0) {
						foreach ($keys as $brackets) {
							$actualKey = str_replace($brackets, '', $key);
							if (!isset($params['filters'][$actualKey])) {
								$params['filters'][$actualKey] = [];
							}
							
							preg_match('([0-9]+)', $brackets, $arrayKeys);

							foreach ($arrayKeys as $arrayKey) {
								$params['filters'][$actualKey][$arrayKey] = $value;
							}
						}
					} else {
						$params['filters'][$key] = $value;
					}
				}
			}
		}

		$this->module = new \Repeater($descriptor, $page, $params);
	}

	public function getTotalCount () {
		return $this->getModule()->getSourceAdapter()->getTotalCount();
	}
}