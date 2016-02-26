<?php

namespace Waxis\Cms\Cms;

class Action extends Ancestor {

	public $cms = null;

	public $table = null;

	public $actions = null;

	public $form = null;

	public $list = null;

	public $formDescriptor = null;

	public $listDescriptor = null;

	public $contentDescriptor = null;

	public $idField = null;

	public $idElement = null;

	public function __construct (&$cms) {
		$this->cms = $cms;

		$this->config = $this->getConfig();

		$this->table = $this->cms->table;
		$this->actions = $this->cms->actions;

		$form = $this->cms->getModuleByType('form');
		if ($form !== null) {
			$this->form = $form;
			$this->formDescriptor = $this->form->module->getDescriptor();
			$this->idField = $this->form->module->getIdField();
			$this->idElement = $this->form->module->getIdElement();
		}

		$list = $this->cms->getModuleByType('list');
		if ($list !== null) {
			$this->list = $list;
			$this->listDescriptor = $this->list->module->getDescriptor();
		}

		if (isset($this->cms->descriptor['content'])) {
			$this->contentDescriptor = $this->cms->descriptor['content'];
		}

	}

	public function execute () {
		# make general changes
		if ($this->table !== null) {
			if ($this->list !== null) {
				$this->addTableToList();
			}

			if ($this->form !== null) {
				$this->addTableToForm();
			}
		}

		# make action specified changes
		if (!empty($this->cms->actions)) {
			foreach ($this->cms->actions as $action) {
				$className = '\Waxis\Cms\Cms\Action\\' . ucfirst($action);

				$executive = new $className($this->cms);
				$executive->execute();
			}
		}
	}

	public function addTableToList () {
		$this->cms->moduleDescriptorExtensions['list'][] = [
			'table' => $this->table
		];
	}

	public function addTableToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'table' => $this->table
		];
	}

	public function addAddButtonToList () {
		$this->cms->descriptorExtensions['list'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('add'),
					'url' 	=> $this->config->getUrl('add'),
				]
			]
		];
	}

	public function addCancelButtonToContent () {
		$this->cms->descriptorExtensions['content'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('cancel'),
					'url' 	=> $this->config->getUrl('main'),
				]
			]
		];
	}

	public function addSaveButtonToContent () {
		$this->cms->descriptorExtensions['content'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('save'),
					'id' 	=> 'save-content',
				]
			]
		];
	}

	public function addCancelButtonToForm () {
		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('cancel'),
					'url' 	=> $this->config->getUrl('main'),
				]
			]
		];
	}

	public function addSaveButtonToForm () {
		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('save'),
					'id' 	=> 'save-form',
				]
			]
		];
	}

	public function addAddNewButtonToEditForm () {
		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				'edit' => [
					[
						'label' => $this->config->getTranslation('addNew'),
						'url' 	=> $this->config->getUrl('add'),
					]
				]
			]
		];
	}

	public function addSaveToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'save' => true
		];
	}

	public function addIdFieldToForm () {
		$structureTypes = ['sections','brows','bcolumns','rows','columns','elements'];
		$formStructureType = 'elements';

		foreach ($structureTypes as $type) {
			if (isset($this->formDescriptor[$type])) {
				$formStructureType = $type;
			}
		}

		$addon = [
			'type' => 'hidden',
			'name' => $this->idField,
		];

		if ($formStructureType != 'elements') {
			$addon = [
				'elements' => [$addon]
			];
		}

		$this->cms->moduleDescriptorExtensions['form'][] = [
			$formStructureType => [
				$addon
			]
		];
	}

	public function addEditButtonToList () {
		$this->cms->moduleDescriptorExtensions['list'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('edit'),
					'url' => $this->cms->createUrl('edit', $this->cms->tab),
				]
			]
		];
	}

	public function addDeleteButtonToList () {
		$this->cms->moduleDescriptorExtensions['list'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('delete'),
					'type' => 'delete',
				]
			]
		];
	}

	public function addAddOrderAfterSaveToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'after' => [
				[
					'class' => '\Waxis\Cms\Cms\Helper\Order',
					'method' => 'addOrder',
					'params' => [
						'idField' => $this->idField,
						'idElement' => $this->idElement,
						'orderField' => $this->orderField,
						'table' => $this->table,
						'params' => $this->orderParams
					]
				]
			],
		];
	}

	public function addCorrectOrderBeforeSaveToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'before' => [
				[
					'class' => '\Waxis\Cms\Cms\Helper\Order',
					'method' => 'correctOrder',
					'params' => [
						'idField' => $this->idField,
						'idElement' => $this->idElement,
						'orderField' => $this->orderField,
						'table' => $this->table,
						'params' => $this->orderParams
					]
				]
			],
		];
	}

	public function addDefaultOrderToList () {
		if (!isset($this->list->module->getDescriptor()['order'])) {
			if ($this->orderParams !== null) {
				foreach ($this->orderParams as $one) {
					$orderOrderBy[] = $one;
					$orderOrder[] = 'ASC';
				}
			}

			$orderOrderBy[] = $this->orderField;
			$orderOrder[] = 'ASC';

			$this->cms->moduleDescriptorExtensions['list'][] = [
				'order' => $orderOrder,
				'orderBy' => $orderOrderBy,
			];
		}
	}

	public function addOrderColumnToList () {
		# if the list doesn't have an order field yet then add it
		if (!$this->hasOrderColumn) {
			$this->cms->moduleDescriptorExtensions['list'][] = [
				'fields' => [
					[
						'label' => $this->config->getTranslation('order'),
						'type' => 'order',
						'name' => $this->orderField,
					]
				]
			];
		}
	}

	public function addHandleImageBeforeSaveToForm () {
		# @todo: remove
		$hasImages = false;
		foreach ($this->form->module->getElements() as $element) {
			if ($element->getType() == 'image') {
				$hasImages = true;
				break;
			}
		}

		if (!$hasImages) {
			return;
		}

		$this->cms->moduleDescriptorExtensions['form'][] = [
			'before' => [
				[
					'class' => '\Waxis\Cms\Cms\Helper\Image',
					'method' => 'handleImage',
				]
			]
		];
	}

	public function addHandleMultiimageBeforeSaveToForm () {
		# @todo: remove
		$hasMultiimages = false;
		foreach ($this->form->module->getElements() as $element) {
			if ($element->getType() == 'multiimage') {
				$hasMultiimages = true;
				break;
			}
		}

		if (!$hasMultiimages) {
			return;
		}

		$this->cms->moduleDescriptorExtensions['form'][] = [
			'before' => [
				[
					'class' => '\Waxis\Cms\Cms\Helper\Image',
					'method' => 'handleMultiimage',
					'updateData' => true,
				]
			]
		];
	}

	public function addSuccessFeedbackToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'data' => [
				'after' => 'sendSuccess'
			]
		];
	}

	public function addFiltersToList () {
		$this->cms->moduleDescriptorExtensions['list'][] = [
			'filters' => $this->cms->list['filters']
		];
	}

	public function addMultilingualWhereToList () {
		$where = '(language like "'.config('app.locale').'")';

		if (isset($this->listDescriptor['where'])) {
			$where = '(' . $this->listDescriptor['where'] . ') && ' . $where;
		}

		$this->cms->moduleDescriptorExtensions['list'][] = [
			'where' => $where
		];
	}


}