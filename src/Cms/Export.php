<?php

namespace Waxis\Cms\Cms;

class Export {

	public $cms = null;

	public $params = null;

	public $list = null;

	public function __construct ($cms, $params) {
		$this->cms = $cms;

		$this->params = $params;
	}

	public function get () {
		$this->list = $this->cms->getModuleByType('list')->module;

		if (!$this->list->isPermitted()) {
			return;
		}

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$this->cms->tab.'-'.date('Y-m-d').'.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, $this->getHeaders(), ',', ' ');

		foreach ($this->getData() as $one) {
			fputcsv($output, $this->getRowData($one), ',', ' ');
		}
	}

	public function getRowData ($one) {
		$rowData = array();

		foreach ($this->getFieldsToShow() as $field) {
			$data = null;

			if (isset($one->{$field})) {
				$data = $one->{$field};
			} else if (isset($one[$field])){
				$data = $one[$field];
			}

			$rowData[] = trim($data);
			//$rowData[] = trim(iconv('UTF-8', 'ISO-8859-2', $data));
		}

		return $rowData;
	}

	public function getData () {
		$data = null;

		// New filtering based on cookies
		// Other was not developed
		$filters = [];
		$filterId = $this->list->getId() . '-filters';
		if (isset($_COOKIE[$filterId])) {
			$filters = json_decode($_COOKIE[$filterId], true);
		}

		$this->list->setFilterValues($filters);
		//$this->list->setFilterValues($this->params);
		$this->list->setLimit(null);


		if (isset($this->params['order'])) {
			$this->list->setOrder($this->params['order']);
		}

		if (isset($this->params['orderBy'])) {
			$this->list->setOrderBy($this->params['orderBy']);
		}

		$data = $this->list->getData();

		if (isset($this->cms->list['export']['converter'])) {
			$data = call_user_func($this->cms->list['export']['converter'], $data);
		}

		return $data;
	}

	public function getFields () {
		return $this->cms->list['export']['fields'];
	}

	public function getHeaders () {
		$headers = array();

		foreach ($this->getFields() as $one) {
			$label = $one['label'];

			if ($label == 'ID') {
				$label = 'Id';
			}

			$headers[] = $label;
		}

		return $headers;
	}

	public function getFieldsToShow () {
		$fieldsToShow = array();

		foreach ($this->getFields() as $one) {
			$fieldsToShow[] = $one['field'];
		}

		return $fieldsToShow;
	}
}