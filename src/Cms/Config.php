<?php

namespace Waxis\Cms\Cms;

class Config {

	public $templateDirectory = '/Template';

	public $translation = [
		'add' => 'add',
		'addNew' => 'add_new',
		'save' => 'save',
		'cancel' => 'cancel',
		'delete' => 'delete',
		'edit' => 'edit',
		'order' => 'order',
	];

	public function getUrls () {
		$base = config('cms.url');

		return $urls = [
			'main' => "$base/%tab",
			'add' => "$base/%tab/add",
			'edit' => "$base/%tab/edit/%id", // access request params and obj vars
			'view' => "$base/%tab/view/%id",
			'export' => "$base/%tab/export",
		];
	}

	public function getUrl ($type) {
		return $this->getUrls()[$type];
	}

	public function getTemplateDirectory () {
		return __DIR__ . $this->templateDirectory . '/';
	}

	public function getTranslation ($key) {
		return \Lang::get('cms.list.buttons.'.$this->translation[$key]);
	}

	public function getTranslations () {
		return $this->translation;
	}

	public function getFiltersDirectory () {
		return $this->filtersDirectory;
	}
}