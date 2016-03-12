<?php

namespace App\Descriptors\Form;

class Admin_add {
	
	public function descriptor () {
		return [
			'id' => 'admins',
			'elements' => [
				[
					'type' => 'image',
					'name' => 'image',
					'label' => 'cms.admins.form.image',
					'imageDescriptor' => 'admin',
				],
				[
					'name' => 'name',
					'label' => 'cms.admins.form.name',
					'required' => true,
				],
				[
					'type' => 'email',
					'name' => 'email',
					'label' => 'cms.admins.form.email',
					'required' => true,
					'validators' => [
						'remote' => [
							'table' => 'admins',
							'field' => 'email',
							'message' => 'cms.admins.form.email_exists'
						]
					],
				],
				[
					'type' => 'password',
					'name' => 'password',
					'label' => 'cms.admins.form.password',
					'required' => true,
					'convert' => 'bcrypt',
				]
			]
		];
	}
}