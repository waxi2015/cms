<?php

namespace Waxis\Cms\Cms\Module;

class Ancestor {

	public $type = null;

	public $descriptor = null;

	public $params = null;

	public $module = null;

	public $extensions = null;

	public function __construct($descriptor, $params = null, $extensions = null) {
		$this->descriptor = $descriptor;
		
		$this->params = $params;

		# only the descriptors array should be merged with
		# the module's descriptor
		if (isset($extensions[$this->type])) {
			$this->extensions = $extensions[$this->type];
		} 
		# set the module object
		$this->setModule();

		# extend the module's descriptor with predefined actions
		if ($this->extensions !== null) {
			$this->extendModules();
		}
	}

	public function extendModules () {
		$moduleDescriptor = $this->module->getDescriptor();
		foreach ($this->extensions as $action) {
			if (isset($moduleDescriptor[key($action)]) && !is_array($moduleDescriptor[key($action)])) {
				# if the extension should override because the value exits and it's not an array
				//$moduleDescriptor[key($action)] = $action[key($action)];
			} else {
				# if the extension should actually extend the param, because it's an array
				$moduleDescriptor = array_merge_recursive($moduleDescriptor, $action);
			}

		}
		$this->setModule($moduleDescriptor);
	}

	public function getDescriptor () {
		return $this->getModule()->getDescriptor();
	}

	public function getModule () {
		if ($this->module == null) {
			$this->setModule();
		}
		
		return $this->module;
	}

	public function getModuleId () {
		return $this->getModule()->getId();
	}

	public function render () {
		echo $this->fetch();
	}

	public function fetch () {
		return $this->getModule()->fetch();
	}
}