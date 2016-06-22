<?php

namespace App\Descriptors\Form;

class Login {
	
	public function descriptor () {
		return array(
			'id' => 'login',
			'elements' => [
				[
					'type' => 'html',
					'content' => '<span class="logo"></span>',
				],
				[
					'name' => 'email',
					'placeholder' => 'cms.login.email',
					'suffix' => '<svg class="svg-login-user"><use xlink:href="/assets/admin/svg/sprite.svg#login-user"></use></svg>',
				],
				[
					'type' => 'password',
					'name' => 'password',
					'placeholder' => 'cms.login.password',
					'suffix' => '<svg class="svg-login-password"><use xlink:href="/assets/admin/svg/sprite.svg#login-password"></use></svg>',
				],
				[
					'type' => 'swap',
					'name' => 'remember',
					'label' => 'cms.login.remember',
					'onText' => '&nbsp;',
					'offText' => '&nbsp;'
				],
				[
					'type' => 'submit',
					'text' => 'cms.login.login',
				],
				/*[
					'type' => 'anchor',
					'class' => 'forgotten-password',
					'text' => 'cms.login.forgotten_password',
				]*/
			],
			'after' => [
				[
					'class' => '\App\Admin',
					'method' => 'login'
				]
			],
			'feedback' => [
				'inactive' => [
					'valid' => false,
					'message' => 'cms.login.inactive'
				],
				'false' => [
					'valid' => false,
					'message' => 'cms.login.wrong_email'
				],
				'true' => [
					'valid' => true,
				]
			],
			'data' => [
				'success' => 'redirectToAdmin'
			]
		);
	}
}