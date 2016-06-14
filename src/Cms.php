<?php

namespace Waxis\Cms;

class Cms extends Cms\Ancestor {

	# describes MODULE => TYPE
	# (which type of action is assigned to a certain module)
	# customAction => 'customModule' 
	public $modules = [
		'add' => 'form',
		'edit' => 'form',
		'list' => 'list',
	];

	public $cmsDescriptor = null;

	public $descriptor = null;

	public $table = null;

	public $tab = null;

	public $request = null;

	public $requestParams = null;

	public $id = null;

	public $page = null;

	public $type = null;

	public $module = null;

	public $title = null;

	public $tabs = null;

	public $mainType = null;

	public $editType = null;

	public $label = null;

	public $form = null;

	public $formId = null;
	
	public $list = null;

	public $listId = null;

	public $buttons = null;

	public $filters = null;

	public $actions = null;

	public $descriptorExtensions = null;

	public $moduleDescriptorExtensions = null;

	public $customAction = null;

	public $multilingual = false;

	public function __construct ($descriptor, $tab, $request) {
		if ($this->descriptor === null) {

			if (!$descriptor instanceof Cms\Descriptor) {
				$descriptorClass = '\App\Descriptors\Cms\\' . ucfirst($descriptor);
				$descriptorObj = new $descriptorClass;
				$descriptor = $descriptorObj->descriptor();
			}

			$this->cmsDescriptor = $descriptor;

			if (isset($descriptor[$tab])) {
				$this->descriptor = $descriptor[$tab];
			}

			$this->tab = $tab;
		}

		$this->request = $request;

		if (isset($this->descriptor['module'])) {
			$moduleName = is_array($this->descriptor['module']) ? $this->descriptor['module']['module'] : $this->descriptor['module'];
			$moduleClass = 'Waxis\Cms\Cms\Module\\' . ucfirst($moduleName);
			$module = new $moduleClass;

			$module->extendDescriptor($this);
		}

		# action defines the type
		if (isset($this->request->action)) {
			$this->type = $this->request->action;

			if ($this->type == 'main') {
				$this->type = $this->getMainType();
			}

			if ($this->type == 'edit') {
				$this->type = $this->getEditType();
			}
		}

		if (isset($this->request->id)) {
			$this->id = $this->request->id;
		}

		if (isset($this->descriptor['table'])) {
			$this->table = $this->descriptor['table'];
		}

		if (isset($this->descriptor['label'])) {
			$this->label = $this->descriptor['label'];
		}

		if (isset($this->descriptor['form'])) {
			$this->form = $this->descriptor['form'];
			$this->formId = $this->getModuleDescriptorByType('form')['id'];
		}

		if (isset($this->descriptor['list'])) {
			$this->list = $this->descriptor['list'];
			$this->listId = $this->getModuleDescriptorByType('list')['id'];
		}

		if (isset($this->descriptor['actions'])) {
			$this->actions = $this->descriptor['actions'];
		}

		if (isset($this->descriptor['custom'])) {
			$this->customAction = $this->descriptor['custom'];
		}

		if (isset($this->descriptor['multilingual']) && $this->descriptor['multilingual'] == true) {
			$this->multilingual = true;
			$this->actions[] = 'multilingual';
		}

		if (isset($this->list['filters'])) {
			$this->actions[] = 'filter';
		}

		# both set cms and module descriptor extensions
		$this->setDescriptorExtensions();

		$this->extendDescriptor();
	}

	public function setDescriptorExtensions () {
		if ($this->descriptorExtensions === null && $this->moduleDescriptorExtensions === null) {
			# execute changes made by actions to $this 
			# eg. extending descriptors
			$action = new Cms\Action($this);
			$action->execute();
		}
	}

	# extend descriptors with predefined actions (eg. add / edit button)
	public function extendDescriptor () {
		$module = $this->getModuleName();

		if ($module === null || !isset($this->descriptorExtensions[$module])) {
			return;
		}

		# add extensions to cms descriptor
		foreach ($this->descriptorExtensions[$module] as $extension) {

			if (isset($this->descriptor[$module])) {
				$this->descriptor[$module] = array_merge_recursive($this->descriptor[$module], $extension);
			}
		}
	}

	public function addModifier ($modifier) {
		$action = new Cms\Action($this);
		$action->$modifier();
	}

	public function hasPermissionTo ($action, $tab) {
		$roles = null;
		if (isset($this->cmsDescriptor[$tab]['roles'])) {
			$roles = $this->cmsDescriptor[$tab]['roles'];
		}

		$role = null;
		if (\Auth::guard('admin')->check() && isset(\Auth::guard('admin')->user()->role)) {
			$role = \Auth::guard('admin')->user()->role;
		}

		if ($roles === null || $role === null) {
			return true;
		}

		switch ($action) {
			case 'reach':
				if (array_key_exists($role, $roles) || in_array($role, $roles)) {
					return true;
				} else {
					return false;
				}
				break;

			default:
				if (isset($roles[$role]) && in_array($action, $roles[$role])) {
					return true;
				} else {
					return false;
				}
				break;
		}
	}

	public function getFirstTab ($nth = 0) {
		foreach ($this->cmsDescriptor as $key => $tab) {
			$first = $key;

			foreach ($this->cmsDescriptor as $childKey => $one) {
				if (isset($one['parent']) && $one['parent'] == $first) {
					return $childKey;
				}
			}

			return $first;
		}
	}

	public function export ($params) {
		$export = new Cms\Export($this, $params);
		echo $export->get();
	}

	public function renderExport () {
		if (!isset($this->list['export'])) {
			return null;
		}

		$this->render('export.phtml');
	}

	public function renderFilters () {
		if ($this->getFilters() === null) {
			return;
		}

		echo $this->render('filter/filters.phtml');
	}

	public function getFilters () {
		if ($this->filters !== null) {
			return $this->filters;
		}

		$moduleName = $this->getModuleName();

		if (isset($this->descriptor[$moduleName]) && isset($this->descriptor[$moduleName]['filters'])) {
			$filters = array();

			foreach ($this->descriptor[$moduleName]['filters'] as $key => $filter) {
				if (!isset($filter['type'])) {
					$filter['type'] = 'text';
				}

				$filter['listId'] = $this->listId;

				switch ($filter['type']) {
					default:
						$filterClass = 'Waxis\Cms\Cms\Filter\\' . ucfirst($filter['type']);
						break;
				}

				$filters[] = new $filterClass($filter);
			}

			$this->filters = $filters;
		}

		return $this->filters;
	}

	public function renderButtons () {
		echo $this->fetchButtons();
	}

	public function fetchButtons () {
		$buttons = '';

		foreach ($this->getButtons() as $button) {
			$buttons .= '&nbsp;' . $button->fetch();
		}

		return $buttons;
	}

	public function getButtons () {
		$moduleName = $this->getModuleName();

		# if the current module has buttons in the descriptors go through them
		if (isset($this->descriptor[$moduleName]) && isset($this->descriptor[$moduleName]['buttons'])) {
			$buttons = array();
			
			foreach ($this->descriptor[$moduleName]['buttons'] as $key => $button) {
				# if it has a numeric key it's a general button
				# (that appears time the module is used)
				if (is_numeric($key)) {
					$button['tab'] = $this->tab;
					$buttons[] = $this->getButton($button);

				# if it's an array then is specified for a type
				# eg. to differentiate add / edit template buttons
				# which both uses form
				} elseif ($key == $this->getType()) {
					foreach ($button as $skey => $typeSpecificButton) {
						$typeSpecificButton['tab'] = $this->tab;
						$buttons[] = $this->getButton($typeSpecificButton);
					}
				}
			}

			return $buttons;
		} else {
			return array();
		}

	}

	public function getButton ($button) {
		if (!isset($button['type'])) {
			$button['type'] = 'abstract';
		}

		if (!isset($button['id'])) {
			$button['id'] = $this->id;
		}

		switch ($button['type']) {
			case 'submit':
				$return = new Cms\Button\Submit($button);
				break;

			default:
				$return = new Cms\Button\Ancestor($button);
				break;
		}

		return $return;
	}

	public function getTabs () {
		if ($this->tabs === null) {
			$tabs = array();

			foreach ($this->cmsDescriptor as $tab => $value) {
				if (!$this->hasPermissionTo('reach', $tab)) {
					continue;
				}
				
				$tabs[$tab] = [
					'name' => $tab,
					'icon' => isset($value['icon']) ? $value['icon'] : null,
					'iconHtml' => isset($value['iconHtml']) ? $value['iconHtml'] : null,
					'label' => trans(isset($value['label']['tab']) ? $value['label']['tab'] : $value['label']['plural']),
					'url' => $this->createUrl('main', $tab),
					'parent' => isset($value['parent']) ? $value['parent'] : null,
					'selected' => $this->tab == $tab ? true : false,
				];

				foreach ($this->cmsDescriptor as $stab => $svalue) {
					if ($stab == $this->tab && isset($svalue['parent']) && $tab == $svalue['parent']) {
						$tabs[$tab]['selected'] = true;
					}
				}
			}

			$this->tabs = $tabs;
		}

		return $this->tabs;
	}

	public function getSubTabs ($tab) {
		$subtabs = array();

		foreach ($this->getTabs() as $key => $one) {
			if ($tab == $one['parent']) {
				$subtabs[$key] = $one;
			}
		}

		return $subtabs;
	}

	public function createUrl ($type, $tab = null) {
		$config = $this->getConfig();

		$url = $config->getUrl($type);

		preg_match_all('(%[a-zA-Z0-9]+)', $url, $matches);
		
		foreach ($matches[0] as $one) {
			$field = str_replace('%','',$one);

			if ($field == 'tab') {
				if ($tab === null) {
					$tab = $this->tab;
				}

				$url = str_replace($one, $tab, $url);	
			} else {
				$value = property_exists($this, $field) ? $this->$field : null;

				if ($value === null) {
					$value = isset($this->_requestParams[$field]) ? $this->_requestParams[$field] : null;
				}

				if ($value !== null) {
					$url = str_replace($one, $value, $url);
				}
			}
			
		}

		return $url;
	}

	public function getPageTitle () {
		$singular = $this->label['singular'];
		$plural = $this->label['plural'];

		if ($this->title === null) {
			switch ($this->getType()) {
				case 'list':
					$title = isset($this->list['label']) ? trans($this->list['label']) : trans($plural);
					break;

				case 'edit':
					$title = isset($this->form['label']) ? trans($this->form['label']) : trans('cms.title.edit',['title'=>trans($singular)]);
					break;

				case 'add':
					$title = trans('cms.title.add',['title'=>trans($singular)]);
					break;
			}

			$this->title = $title;
		}

		return $this->title;
	}

	public function setType ($type) {
		$this->type = $type;
	}

	public function renderModule () {
		return $this->getModule()->render();
	}

	public function getModuleDescriptor () {
		return $this->getModule()->getDescriptor();

	}

	public function getModule () {
		if ($this->module === null) {
			$type = $this->modules[$this->getType()];

			$this->module = $this->getModuleByType($type);
		}

		return $this->module;
	}

	public function getModuleDescriptorByType ($module) {
		return $this->getModuleByType($module)->getDescriptor();

	}

	public function getModuleByType ($type) {
		$module = null;

		if ($this->$type === null) {
			return null;
		}

		switch ($type) {
			case 'list':
				$page = isset($this->request->page) ? $this->request->page : null;

				$descriptor = isset($this->list['descriptor']) ? $this->list['descriptor'] : $this->list;

				$module = new Cms\Module\Repeater($descriptor, array('page' => $page), $this->moduleDescriptorExtensions);
				break;

			case 'form':
				$descriptor = isset($this->form['descriptor']) ? $this->form['descriptor'] : $this->form;

				$module = new Cms\Module\Form($descriptor, array('id' => $this->getId(), 'data' => $this->getFormData(), 'type' => $this->type), $this->moduleDescriptorExtensions);
				break;
		}

		return $module;
	}

	public function getModuleName () {
		$type = $this->getType();

		if (isset($this->modules[$type])) {
			return $this->modules[$type];
		}

		return null;
	}

	public function getFormData () {
		if (isset($this->form['data'])) {
			return $this->form['data'];
		}
	}

	public function getEditType () {
		if ($this->editType === null) {
			$descriptor = $this->descriptor;

			$type = 'edit';
			
			$this->editType = $type;
		}

		return $this->editType;
	}

	public function getMainType () {
		if ($this->mainType === null) {
			$descriptor = $this->descriptor;

			$type = 'list';

			if (!isset($descriptor['list'])) {
				if (isset($descriptor['form'])) {
					$type = 'edit';
				} elseif (isset($descriptor['profile'])) {
					$type = 'profile';
				} else {
					$type = $this->getCustomAction();
				}
			}
			
			$this->mainType = $type;
		}

		return $this->mainType;
	}

	public function getTable () {
		return $this->table;
	}

	public function getType () {
		return $this->type;
	}

	public function getId () {
		return $this->id;
	}

	public function getListId () {
		return $this->listId;
	}

	public function getFormId () {
		return $this->formId;
	}

	public function getCustomAction () {
		return $this->customAction;
	}

	public function setTab ($tab) {
		$this->tab = $tab;
	}
}