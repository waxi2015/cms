<?php

namespace Waxis\Cms\Cms\Button;

class Ancestor extends \Waxis\Cms\Cms\Ancestor {

	public $type = 'button'; // also directory name

	public $template = 'abstract.phtml';

	public $label = null;

	public $url = null;

	public $mode = 'reload';

	public $baseClass = null;

	public $class = null;

	public $id = null;

	public $tab = null;

	public function __construct ($descriptor) {

		if (isset($descriptor['label'])) {
			$this->label = $descriptor['label'];
		}

		if (isset($descriptor['template'])) {
			$this->template = $descriptor['template'];
		}

		if (isset($descriptor['url'])) {
			$this->url = $descriptor['url'];
		}

		if (isset($descriptor['mode'])) {
			$this->mode = $descriptor['mode'];
		}

		if (isset($descriptor['class'])) {
			$this->class = $descriptor['class'];
		}

		if (isset($descriptor['tab'])) {
			$this->tab = $descriptor['tab'];
		}

		if (isset($descriptor['id'])) {
			$this->id = $descriptor['id'];
		}

		parent::__construct($descriptor);
	}

	public function getHrefString () {
		return 'href="' . $this->getUrl() . '"';
	}

	public function getLabel () {
		return $this->label;
	}

	public function getUrl () {
		# replace data vars to values
		preg_match_all('(%[a-zA-Z0-9]+)', $this->url, $matches);
		
		foreach ($matches[0] as $one) {
			$var = str_replace('%','',$one);
			$value = isset($this->$var) ? $this->$var : false;

			$this->url = str_replace($one, $value, $this->url);
		}

		return $this->url;
	}

	public function getMode () {
		return $this->mode;
	}

	public function getClass () {
		return $this->class;
	}

	public function getClassString () {
		$class = 'btn' . ($this->baseClass ? ' ' . $this->baseClass : null);

		if ($this->class !== null) {
			$class .= ' ' . $this->class;	
		}

		if ($class !== null) {
			return ' class="' . $class . '"';
		}

		return null;
	}

	public function getId () {
		return $this->id;
	}

	public function getIdString () {
		if ($this->id === null) {
			return null;
		}

		return ' id="' . $this->id . '"';
	}

	public function getType () {
		return $this->type;
	}
}