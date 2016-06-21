<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends \Waxis\Cms\CmsController
{
	public $descriptor = 'admin';

	public function password (Request $request) {
		$this->cms->setTab('admins');
		$this->data['tab'] = 'admins';
		$this->data['form'] = new \Form('adminpassword', $request->id);

		return view('admin.password', $this->data);
	}

	public function dashboard()
	{
		$this->data['dashboard'] = new \Stat('dashboard');
		
		return view('admin.dashboard', $this->data);
	}
}
