<?php

Route::group(['middleware' => 'web'], function(){
	# Auth routes
	Route::get('/admin/login', 'App\Http\Controllers\\' . config('cms.controller') . '@login');
	Route::get('/admin/logout', ['as' => 'logout', 'uses' => 'App\Http\Controllers\\' . config('cms.controller') . '@logout']);

	# General routes
	Route::any('/admin', 'App\Http\Controllers\\' . config('cms.controller') . '@index');
	Route::any('/admin/{tab}', 'App\Http\Controllers\\' . config('cms.controller') . '@main');
	Route::any('/admin/{tab}/add', 'App\Http\Controllers\\' . config('cms.controller') . '@add');
	Route::any('/admin/{tab}/export', 'App\Http\Controllers\\' . config('cms.controller') . '@export');
	Route::any('/admin/{tab}/import-content', 'App\Http\Controllers\\' . config('cms.controller') . '@importcontent');
	Route::any('/admin/{tab}/edit/{id}', 'App\Http\Controllers\\' . config('cms.controller') . '@edit');
	Route::any('/admin/{tab}/{page}', 'App\Http\Controllers\\' . config('cms.controller') . '@main');

	# Tab routes
	Route::any('/admin/admins/password/{id}', 'App\Http\Controllers\\' . config('cms.controller') . '@password');
});