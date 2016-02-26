<?php

namespace Waxis\Cms;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Routing\Route;

class CmsController extends Controller
{
	public $descriptor = null;

	public $cms = null;

	public $data = null;

	public $viewsPath = null;

	public function __construct(Request $request, Route $route) {
		$action = explode('@',$route->getActionName())[1];
		$tab = $request->tab;

		$request->action = $action;

		$this->cms = new \Cms($this->descriptor, $tab, $request);

    	$this->data = [
    		'cms'=> $this->cms,
    		'tab' => $tab
    	];

		$this->viewsPath = config('cms.views');

		/*$adminClass = APP_NAME . '_Admin';
		if (!$adminClass::getInstance()->isLoggedIn() && !in_array($action, array('login', 'logout'))) {
			$this->_redirect('/admin/login');
		}*/
	}

	public function index()
	{
		$firstTab = key($this->cms->cmsDescriptor);

		return redirect(config('cms.url') . '/' . $firstTab);

		/*$adminClass = APP_NAME . '_Admin';

		if ($adminClass::getInstance()->isLoggedIn()) {
			$this->_redirect('/admin/' . $firstTab);
		} else {
			$this->_redirect('/admin/login');
		}*/
	}

	public function main () {
		$type = $this->cms->getMainType();

		switch ($type) {
			case 'list':
				return view("$this->viewsPath.list", $this->data);
				break;

			default:
				return $this->{$type}();
				break;
		}
	}

	public function edit () {
		switch ($this->cms->getEditType()) {
			case 'edit':
				return view("$this->viewsPath.edit", $this->data);
				break;

			case 'add':
				return view("$this->viewsPath.add", $this->data);
				break;
		}
	}

	public function add () {
		return view("$this->viewsPath.add", $this->data);
	}

	public function export (Request $request) {
		$this->cms->export($request);
	}
}
