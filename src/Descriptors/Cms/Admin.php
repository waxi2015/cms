<?php

namespace App\Descriptors\Cms;

class Admin {

	public function descriptor()
	{
		return [

			'admins' => [
				'icon' => 'fa fa-user-md',
				'label' => [
					'tab' => 'cms.admins.tab',
					'singular' => 'cms.admins.singular',
					'plural' => 'cms.admins.plural',
				],
				'table' => 'admins',
				'actions' => ['add','edit','delete'],
				'list' => [
					'descriptor' => [
						'id' => 'admins',
						'fields' => [
							[
								'label' => 'cms.admins.list.name',
								'name' => 'name',
							],
							[
								'label' => 'cms.admins.list.email',
								'name' => 'email',
							],
						],
						'buttons' => [
							[
								'label' => 'cms.admins.list.button_change_password',
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