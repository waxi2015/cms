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
		$this->middleware('auth:admin', ['except' => ['login', 'index']]);

		$action = explode('@',$route->getActionName())[1];
		$tab = $request->tab;

		$request->action = $action;

		$this->cms = new \Cms($this->descriptor, $tab, $request);

    	$this->data = [
    		'cms'=> $this->cms,
    		'tab' => $tab
    	];

		$this->viewsPath = config('cms.views');
	}

	public function index()
	{
		$firstTab = $this->cms->getFirstTab();


		if (\Auth::guard('admin')->check()) {
			return redirect(config('cms.url') . '/' . $firstTab);
		} else {
			return redirect(config('cms.url') . '/login');
		}
	}

	public function login () {
		$firstTab = $this->cms->getFirstTab();

		if (\Auth::guard('admin')->check()) {
			return redirect(config('cms.url') . '/' . $firstTab);
		} else {
			$form = new \Form('login');

			return view("$this->viewsPath.login", compact('form'));
		}
	}

	public function logout () {
		\Auth::guard('admin')->logout();

		return redirect(config('cms.url'));
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
		return $this->cms->export($request);
	}
}
