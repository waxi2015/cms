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
		$except = ['getemail'];

		$action = explode('@',$route->getActionName())[1];

		if (!in_array($action, $except)) {
			\Lang::setLocale(config('cms.locale'));

			$this->middleware('auth:admin', ['except' => ['login', 'index', 'newpassword']]);

			$tab = $request->tab;

			$request->action = $action;

			$this->cms = new \Cms($this->descriptor, $tab, $request);

	    	$this->data = [
	    		'cms'=> $this->cms,
	    		'tab' => $tab
	    	];

			$this->viewsPath = config('cms.views');
		}
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

	public function main (Request $request) {
		$type = $this->cms->getMainType();

		if (!$this->cms->hasPermissionTo('reach', $request->tab)) {
			\App::abort(403, 'Unauthorized action.');
		}
		
		$this->data['titlePrefix'] = $this->cms->label['tab'] . ' | ';
		
		switch ($type) {
			case 'list':
				return view("$this->viewsPath." . $this->cms->getListTemplate(), $this->data);
				break;

			default:
				\Log::info($type, $_SERVER);
				return $this->{$type}($request);
				break;
		}
	}

	public function edit (Request $request) {
		if (!$this->cms->hasPermissionTo('edit', $request->tab)) {
			if (!$this->cms->hasPermissionTo('view', $request->tab)) {
				\App::abort(403, 'Unauthorized action.');
			} else {
				$this->cms->addModifier('addViewModeToForm');
			}
		}
		
		$this->data['titlePrefix'] = $this->cms->label['tab'] . ' | ';

		switch ($this->cms->getEditType()) {
			case 'edit':
				return view("$this->viewsPath.edit", $this->data);
				break;

			case 'add':
				return view("$this->viewsPath.add", $this->data);
				break;
		}
	}

	public function add (Request $request) {
		if (!$this->cms->hasPermissionTo('add', $request->tab)) {
			\App::abort(403, 'Unauthorized action.');
		}
		
		$this->data['titlePrefix'] = $this->cms->label['tab'] . ' | ';

		return view("$this->viewsPath.add", $this->data);
	}

	public function export (Request $request) {
		if (!$this->cms->hasPermissionTo('export', $request->tab)) {
			\App::abort(403, 'Unauthorized action.');
		}

		return $this->cms->export($request);
	}

	public function importcontent()
	{
		$tab = $this->cms->tab;

		$table = $this->cms->descriptor['table'];
		$file = $this->cms->descriptor['file'];

		if (\Waxis\Cms\Cms\Module\Content::import($table, $file)) {
			$return = [
				'valid' => true,
				'message' => 'cms.translation.import_success'
			];
		} else {
			$return = [
				'valid' => false,
				'message' => 'cms.translation.import_error'
			];
		}

		return $return;
	}

	public function getemail (Request $request) {
		if (!\Auth::guard('admin')->check()) {
			\App::abort(403, 'Unauthorized action.');
		}

		$emails = $request->emails;

		$email = array_values($emails)[0];
		array_shift($emails);

		$template = to_array(\DB::table('email_templates')->where('identifier', $email['email'])->get())[0];

		$formDescriptor = \App\Descriptors\Form\Email::descriptor();

		$items = [];
		$tags = '';

		foreach ($email['to'] as $key => $to) {
			$items[$to['email']] = $to['name'];
			$tags .= $to['email'];
			addComma($key, $email['to'], $tags, '');
		};

		$formDescriptor['elements'][0]['items'] = $items;

		$formData = [
			'recipients' => $tags,
			'subject' => $template['subject'],
			'message' => $template['content'],
			'layout' => $template['layout'],
			'to' => encode(json_encode($items)),
		];

		if (isset($email['params'])) {
			$formData['params'] = encode(json_encode($email['params']));
		}

		if (!empty($emails)) {
			$formData['emails'] = encode(json_encode($emails));
		}

		$form = new \Form($formDescriptor, $formData);

		$response['html'] = $form->fetch();

		return $response;
	}
}
