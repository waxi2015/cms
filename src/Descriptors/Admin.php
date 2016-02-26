<?php

namespace App\Descriptors\Cms;

class Admin {

	public function descriptor()
	{
		return [
			'custom' => [
				'label' => [
					'tab' => 'Custom tab',
				],
				'custom' => 'custom',
			],
			
			'logout' => [
				'icon' => 'fa fa-file',
				'label' => [
					'tab' => 'Kilépés',
				],
				'custom' => 'logout',
			],
		];
	}
}