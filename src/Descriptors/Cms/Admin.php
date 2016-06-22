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
								'label' => 'cms.admins.list.role',
								'name' => 'role',
								'source' => [
									'admin' => 'Admin'
								],
							],
							[
								'label' => 'cms.admins.list.status',
								'name' => 'status',
								'source' => [
									1 => 'cms.admins.list.active',
									0 => 'cms.admins.list.inactive',
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


			'translation-contents' => [
				'roles' => [
					'admin' => ['edit'],
				],
				'icon' => 'fa fa-language',
				'label' => [
					'tab' => 'cms.translation.tab',
					'singular' => 'cms.translation.singular',
					'plural' => 'cms.translation.plural',
				],
				'module' => 'content'
			],

			'email-templates' => [
				'roles' => [
					'admin' => ['add','edit'/*,'delete'*/],
				],
				'icon' => 'fa fa-envelope',
				'label' => [
					'tab' => 'cms.emails.tab',
					'singular' => 'cms.emails.singular',
					'plural' => 'cms.emails.plural',
				],
				'table' => 'email_templates',
				'actions' => ['edit','add'],
				'list' => [
					'descriptor' => [
						'id' => 'email-templates',
						'limit' => 30,
						'orderBy' => 'receiver',
						'order' => 'ASC',
						'fields' => [
							[
								'label' => 'cms.emails.list_label_name',
								'name' => 'name',
								'clickable' => true,
							],
							[
								'label' => 'cms.emails.list_label_receiver',
								'name' => 'receiver',
							],
							[
								'label' => 'cms.emails.list_label_trigger',
								'name' => 'description',
							],
						]
					],
					'filters' => [
						[
							'name' => 'name',
							'placeholder' => trans('cms.emails.list_label_name'),
							'fields' => ['name']
						],
					]
				],
				'form' => [
					'descriptor' => [
						'id' => 'email-template',
						'sections' => [
							[
								'elements' => [
									[
										'name' => 'identifier',
										'label' => 'cms.emails.form_label_identifier',
										'required' => true,
									],
									[
										'name' => 'receiver',
										'label' => 'cms.emails.form_label_receiver',
										'required' => true,
									],
									[
										'name' => 'name',
										'label' => 'cms.emails.form_label_name',
										'required' => true,
									],
									[
										'type' => 'textarea',
										'name' => 'description',
										'label' => 'cms.emails.form_label_description',
										'required' => true,
									],
									/*[
										'type' => 'select',
										'name' => 'layout',
										'label' => 'cms.emails.form_label_layout',
										'addEmpty' => true,
										'items' => [
											'labs' => 'Labs',
											'stock' => 'Stock',
										],
										'required' => true,
									],*/
									[
										'name' => 'subject',
										'label' => 'cms.emails.form_label_subject',
										'required' => true,
									],
									[
										'type' => 'editor',
										'name' => 'content',
										'css' => '/assets/admin/css/editor/email.css',
										'label' => 'cms.emails.form_label_content',
										'toolbar' => [
											['Bold', 'Italic', 'Underline', 'Link', 'Unlink', 'Undo', 'Redo']
										],
										'required' => true,
									],
								],
							],
						]
					]
				]
			],
		];
	}
}