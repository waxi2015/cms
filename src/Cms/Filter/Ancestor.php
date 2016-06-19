<?php

namespace Waxis\Cms\Cms\Filter;

class Ancestor extends \Waxis\Cms\Cms\Ancestor {

	public $type = 'filter';

	public $listId = null;
	
	public $name = null;

	public $id = null;

	public $placeholder = null;

	public $fields = null;

	public $order = 'ASC';

	public $by = 'id';

	public function __construct ($descriptor) {
		$this->name = $descriptor['name'];
		$this->fields = $descriptor['fields'];

		if (isset($descriptor['id'])) {
			$this->id = $descriptor['id'];
		} else {
			$this->id = $descriptor['name'];
		}

		if (isset($descriptor['placeholder'])) {
			$this->placeholder = $descriptor['placeholder'];
		}

		if (isset($descriptor['listId'])) {
			$this->listId = $descriptor['listId'];
		}
	}

	public function getAttributesString ($key = null) {
		$return = '';

		if ($this->placeholder !== null) {
			$placeholder = $key !== null ? $this->placeholder[$key] : $this->placeholder;
			$return .= ' placeholder="' . $placeholder . '"';
		}

		if ($this->id !== null) {
			$id = $key !== null ? $this->id . '-' . $key : $this->id;
			$return .= ' id="' . $id . '"';
		}

		if ($this->name !== null) {
			$name = $key !== null ? $this->name . "[$key]" : $this->name;
			$return .= ' name="' . $name . '"';
		}

		return $return;
	}

	public function getName () {
		return $this->name;
	}

	public function getId () {
		return $this->id;
	}

	public function getPlaceholder () {
		return $this->placeholder;
	}

	public function getFields () {
		return $this->fields;
	}

	public function getListId () {
		return $this->listId;
	}

	public function getValue () {
		if (isset($_COOKIE[$this->getListId() . '-filters'])) {
			$filters = json_decode($_COOKIE[$this->getListId() . '-filters'], true);

			$params = [];
			foreach ($filters as $key => $value) {
				if ($value != '') {
					if (preg_match('(\[[0-9]+\])', $key, $keys) != 0) {
						foreach ($keys as $brackets) {
							$actualKey = str_replace($brackets, '', $key);
							if (!isset($params[$actualKey])) {
								$params[$actualKey] = [];
							}
							
							preg_match('([0-9]+)', $brackets, $arrayKeys);

							foreach ($arrayKeys as $arrayKey) {
								$params[$actualKey][$arrayKey] = $value;
							}
						}
					} else {
						$params[$key] = $value;
					}
				}
			}

			if (isset($params[$this->getId()])) {
				return $params[$this->getId()];
			}
		}
	}
}