<?php

namespace Waxis\Cms\Cms\Filter;

class Ancestor extends \Waxis\Cms\Cms\Ancestor {

	public $type = 'filter';

	public $listId = null;
	
	public $name = null;

	public $id = null;

	public $placeholder = null;

	public $fields = null;

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
}