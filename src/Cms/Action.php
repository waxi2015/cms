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

	public $idField = null;

	public $idElement = null;

	public $guard = 'admin';

	public function __construct (&$cms, $guard = null) {
		$this->cms = $cms;

		$this->config = $this->getConfig();

		$this->table = $this->cms->table;
		$this->actions = $this->cms->actions;

		if ($guard !== null) {
			$this->guard = $guard;
		}

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

	}

	public function execute () {
		# make general changes
		if ($this->table !== null) {
			if ($this->list !== null) {
				$this->addTableToList();
				$this->addPermissionToList();
			}

			if ($this->form !== null) {
				$this->addTableToForm();
				$this->addPermissionToForm();
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

	public function addViewModeToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'viewMode' => true
		];
	}

	public function addPermissionToList () {
		if (!isset($this->list->module->getDescriptor()['permission'])) {
			$this->cms->moduleDescriptorExtensions['list'][] = [
				'permission' => $this->guard
			];
		}
	}

	public function addPermissionToForm () {
		if (!isset($this->form->module->getDescriptor()['permission'])) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'permission' => $this->guard
			];
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
		if (!$this->cms->hasPermissionTo('add', $this->cms->tab)) {
			return;
		}

		$this->cms->descriptorExtensions['list'][] = [
			'buttons' => [
				[
					'class' => 'btn-primary',
					'label' => $this->config->getTranslation('add'),
					'url' 	=> $this->config->getUrl('add'),
				]
			]
		];
	}

	public function addCancelButtonToForm () {
		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				[
					'class' => 'btn-plain',
					'label' => $this->config->getTranslation('cancel'),
					'url' 	=> $this->config->getUrl('main'),
				]
			]
		];
	}

	public function addSaveButtonToForm () {
		if (!$this->cms->hasPermissionTo('edit', $this->cms->tab) && !$this->cms->hasPermissionTo('add', $this->cms->tab)) {
			return;
		}

		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				[
					'class' => 'btn-primary btn-can-load',
					'label' => $this->config->getTranslation('save'),
					'id' 	=> 'save-form',
					'data' => [
						'loading-text' => "<span class='fa fa-spinner fa-spin fa-3x fa-fw'></span>"
					]
				]
			]
		];
	}

	public function addAddNewButtonToForm () {
		$this->cms->descriptorExtensions['form'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('addNew'),
					'url' 	=> $this->config->getUrl('add'),
				]
			]
		];
	}

	public function addSaveToForm () {
		if (!array_key_exists('save',$this->form->module->getDescriptor())) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'save' => true
			];
		}
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
			'class' => 'hidden',
			'type' => 'hidden',
			'name' => $this->idField,
		];

		if ($formStructureType != 'elements') {
			$addon = [
				'class' => 'hidden',
				'elements' => [$addon]
			];
		}

		$this->cms->moduleDescriptorExtensions['form'][] = [
			$formStructureType => [
				$addon
			]
		];
	}

	public function addCreatedAtFieldToAddForm () {
		$structureTypes = ['sections','brows','bcolumns','rows','columns','elements'];
		$formStructureType = 'elements';

		foreach ($structureTypes as $type) {
			if (isset($this->formDescriptor[$type])) {
				$formStructureType = $type;
			}
		}

		$addon = [
			'class' => 'hidden',
			'type' => 'hidden',
			'name' => 'created_at',
			'default' => date('Y-m-d H:i:s'),
		];

		if ($formStructureType != 'elements') {
			$addon = [
				'class' => 'hidden',
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
		if (!$this->cms->hasPermissionTo('edit', $this->cms->tab)) {
			return;
		}

		$this->cms->moduleDescriptorExtensions['list'][] = [
			'buttons' => [
				[
					'label' => $this->config->getTranslation('edit'),
					'url' => $this->cms->createUrl('edit', $this->cms->tab),
					'type' => 'edit',
				]
			]
		];
	}

	public function addDeleteButtonToList () {
		if (!$this->cms->hasPermissionTo('delete', $this->cms->tab)) {
			return;
		}

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
		if (!$this->cms->hasPermissionTo('order', $this->cms->tab)) {
			return;
		}

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

	public function addSuccessFeedbackToForm () {
		if (!isset($this->formDescriptor['feedback'])) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'feedback' => []
			];
		}

		if (!isset($this->formDescriptor['feedback']['true'])) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'feedback' => [
					'true' => [
						'message'=>\Lang::get('cms.form.save_success_msg'),
						'valid'=>true
					]
				]
			];
		}
	}

	public function addErrorFeedbackToForm () {
		if (!isset($this->formDescriptor['feedback'])) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'feedback' => []
			];
		}

		if (!isset($this->formDescriptor['feedback']['false'])) {
			$this->cms->moduleDescriptorExtensions['form'][] = [
				'feedback' => [
					'false' => [
					 	'message'=>\Lang::get('cms.form.save_error_msg'),
					 	'valid'=>false
			 		]
			 	]
			];
		}
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

	public function addMultilingualToForm () {
		$this->cms->moduleDescriptorExtensions['form'][] = [
			'multilingual' => true
		];
	}
}