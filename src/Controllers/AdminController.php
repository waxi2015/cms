<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends \Waxis\Cms\CmsController
{
	public $descriptor = 'admin';

	public function custom()
	{
		// do anything here

		echo 'This is a custom tab';
	}
}
