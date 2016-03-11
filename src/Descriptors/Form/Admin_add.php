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
					'label' => 'Profil kép',
					'imageDescriptor' => 'admin',
				],
				[
					'name' => 'name',
					'label' => 'Név',
					'required' => true,
				],
				[
					'type' => 'email',
					'name' => 'email',
					'label' => 'Email',
					'required' => true,
					'validators' => [
						'remote' => [
							'table' => 'admins',
							'field' => 'email',
							'message' => 'Ez az email cím már létezik'
						]
					],
				],
				[
					'type' => 'password',
					'name' => 'password',
					'label' => 'Jelszó',
					'required' => true,
					'convert' => 'bcrypt',
				]
			]
		];
	}
}