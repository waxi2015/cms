<?php

namespace App\Descriptors\Cms;

class Admin {

	public function descriptor()
	{
		return [

			'admins' => [
				'roles' => [ # just remove to be accessible by any admin type
					'admin' => ['add','edit','delete'/*,'order','view'*/],
				],
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
						'orderBy' => 'firstname',
						'order' => 'ASC',
						'fields' => [
							[
								'type' => 'image',
								'name' => 'photo',
								'label' => '&nbsp;',
								'class' => 'rounded',
								'value' => '/image/admin/thumbnail/{photo}',
								'clickable' => true,
							],
							[
								'label' => 'cms.admins.list.name',
								'name' => 'name',
								'value' => '{firstname} {lastname}',
								'clickable' => true,
							],
							[
								'label' => 'cms.admins.list.email',
								'name' => 'email',
							],
							[
								'label' => 'Role',
								'name' => 'role',
								'source' => [
									'admin' => 'Admin'
								],
							],
							[
								'label' => 'Status',
								'name' => 'status',
								'source' => [
									1 => 'Active',
									0 => 'Inactive',
								],
							],
						],
						'buttons' => [
							[
								'label' => 'cms.admins.list.button_change_password',
								'class' => 'btn btn-primary',
								'url' => '/admin/admins/password/%id',
							]
						],
						'limit' => 50
					],
				],
				'form' => [
					'descriptor' => 'admin'
				],
			],
		];
	}
}