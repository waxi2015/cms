<?php

namespace App\Descriptors\Form;

class Adminpassword {
	
	public function descriptor () {
		return array(
			'id' => 'change-password',
			'table' => 'admins',
			'save' => true,
			'elements' => [
				[
					'type' => 'hidden',
					'name' => 'id',
				],
				[
					'type' => 'password',
					'name' => 'password',
					'label' => 'Jelszó',
					'required' => true,
					'convert' => 'bcrypt',
					'load' => false,
				]
			],
			'feedback' => [
				'true' => [
					'valid' => true,
					'message' => 'Jelszó módosítás sikeres'
				]
			]
		);
	}
}