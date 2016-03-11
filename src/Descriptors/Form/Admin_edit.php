<?php

namespace App\Descriptors\Form;

class Admin_edit {
	
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
					'name' => 'email',
					'label' => 'Email',
					'readonly' => true,
				],
			]
		];
	}
}