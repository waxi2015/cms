<?php

namespace App\Descriptors\Form;

class Admin_add {
	
	public function descriptor () {
		return [
			'id' => 'admins',
			'before' => [
				[
					'class' => '\App\Converters\Emails',
					'method' => 'adminsBefore',
					'updateData' => true
				]
			],
			'after' => [
				[
					'class' => '\App\Converters\Emails',
					'method' => 'adminsAfter',
					'workWithSaveData' => true,
				]
			],
			'sections' => [
				[
					'class' => 'col-lg-10 col-md-9 col-sm-8 col-xs-12',
					'brows' => [
						[
							'rows' => [
								[
									'columns' => [
										[
											'width' => ['md' => 2],
											'elements' => [
												[
													'type' => 'label',
													'label' => 'Name',
													'required' => true,
												],
											]
										],
										[
											'width' => ['md' => 5, 'sm' => 6, 'xs' => 12],
											'class' => 'full-size',
											'elements' => [
												[
													'name' => 'firstname',
													'placeholder' => 'First name',
													'required' => true
												],
											]
										],
										[
											'width' => ['md' => 5, 'sm' => 6, 'xs' => 12],
											'class' => 'full-size',
											'elements' => [
												[
													'name' => 'lastname',
													'placeholder' => 'Last name',
													'required' => true
												],
											]
										],
									]
								],

								[
									'elements' => [
										[
											'type' => 'email',
											'name' => 'email',
											'label' => 'cms.admins.form.email',
											'prefix' => '<span class="fa fa-envelope"></span>',
											'validators' => [
												'remote' => [
													'table' => 'admins',
													'field' => 'email',
													'message' => 'cms.admins.form.email_exists'
												]
											],
											'required' => true,
										],
										[
											'type' => 'select',
											'name' => 'role',
											'label' => 'Role',
											'addEmpty' => true,
											'source' => [
												'admin' => 'Admin'
											],
											'required' => true,
										],
									],
								]
							]
						],
					]
				],
				[
					'class' => 'col-lg-2 col-md-3 col-sm-4 col-xs-12 no-tab empty side-column',
					'brows' => [
						[
							'elements' => [
								[
									'type' => 'image',
									'name' => 'photo',
									'label' => 'cms.admins.form.image',
									'imageDescriptor' => 'admin',
									'thumbnail' => 'form',
								],
								[
									'type' => 'radiogroup',
									'name' => 'status',
									'label' => 'Status',
									'source' => [
										1 => 'Active',
										0 => 'Inactive',
									],
									'required' => true,
								],
							],
						]
					]
				],
			]
		];
	}
}