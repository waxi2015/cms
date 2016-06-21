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
					'label' => 'cms.admins.form.password',
					'required' => true,
					'convert' => 'bcrypt',
					'load' => false,
					'validators' => [
						'securePassword'
					]
				]
			],
			'feedback' => [
				'true' => [
					'valid' => true,
					'message' => 'cms.admins.form.password_success_msg'
				]
			]
		);
	}
}