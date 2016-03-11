<?php

namespace App\Descriptors\Cms;

class Admin {

	public function descriptor()
	{
		return [

			'admins' => [
				'icon' => 'fa fa-user-md',
				'label' => [
					'tab' => 'Admin felhasználók',
					'singular' => 'Admin',
					'plural' => 'Admin felhasználók',
				],
				'table' => 'admins',
				'actions' => ['add','edit','delete'],
				'list' => [
					'descriptor' => [
						'id' => 'admins',
						'fields' => [
							[
								'label' => 'Név',
								'name' => 'name',
							],
							[
								'label' => 'Email',
								'name' => 'email',
							],
						],
						'buttons' => [
							[
								'label' => 'Jelszó módosítása',
								'class' => 'btn btn-primary',
								'url' => '/admin/admins/password/%id',
							]
						]
					]
				],
				'form' => [
					'descriptor' => 'admin'
				],
			],
		];
	}
}