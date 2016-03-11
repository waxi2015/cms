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
					'placeholder' => 'Email',
					'suffix' => '<svg class="svg-login-user"><use xlink:href="/svg/admin/sprite.svg#login-user"></use></svg>',
					'required' => true,
				],
				[
					'type' => 'password',
					'name' => 'password',
					'placeholder' => 'Jelszó',
					'suffix' => '<svg class="svg-login-password"><use xlink:href="/svg/admin/sprite.svg#login-password"></use></svg>',
					'required' => true,
				],
				[
					'type' => 'swap',
					'name' => 'remember',
					'label' => 'Jegyezzen meg',
					'onText' => '&nbsp;',
					'offText' => '&nbsp;'
				],
				[
					'type' => 'submit',
					'text' => 'Belépés',
				],
				/*[
					'type' => 'anchor',
					'class' => 'forgotten-password',
					'text' => 'Elfelejtett jelszó',
				]*/
			],
			'after' => [
				[
					'class' => '\App\Admin',
					'method' => 'login'
				]
			],
			'feedback' => [
				'false' => [
					'valid' => false,
					'message' => 'Hibás jelszó vagy email'
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