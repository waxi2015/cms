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
					'label' => 'cms.admins.form.image',
					'imageDescriptor' => 'admin',
				],
				[
					'name' => 'name',
					'label' => 'cms.admins.form.name',
					'required' => true,
				],
				[
					'name' => 'email',
					'label' => 'cms.admins.form.email',
					'readonly' => true,
				],
			]
		];
	}
}