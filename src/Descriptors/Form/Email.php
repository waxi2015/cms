<?php

namespace App\Descriptors\Form;

class Email {
	
	public static function descriptor () {
		return array(
			'id' => 'email-confirmation',
			'permission' => 'admin',
			'after' => [
				[
					'class' => '\App\Email',
					'method' => 'sendOut',
				]
			],
			'elements' => [
				[
					'type' => 'tags',
					'name' => 'recipients',
					'label' => 'Recipients',
					'required' => true,
				],
				[
					'name' => 'subject',
					'placeholder' => 'Subject',
					'required' => true,
				],
				[
					'type' => 'editor',
					'name' => 'message',
					'css' => '/assets/admin/css/editor/email.css',
					'required' => true,
					'toolbar' => [
						['Bold', 'Italic', 'Underline', 'Link', 'Unlink', 'Undo', 'Redo']
					]
				],
				[
					'type' => 'hidden',
					'name' => 'layout',
				],
				[
					'type' => 'hidden',
					'name' => 'to',
				],
				[
					'type' => 'hidden',
					'name' => 'emails',
				],
				[
					'type' => 'hidden',
					'name' => 'params',
				],
				[
					'type' => 'hidden',
					'name' => 'skip',
				]
			],
			'feedback' => [
				'true' => [
					'valid' => true,
					'message' => 'Email sent'
				],
				'false' => [
					'valid' => false,
					'message' => 'There was an error during sending out email',
				]
			],
			'data' => [
				'success' => 'waxcms.closeConfirmEmail'
			]
		);
	}
}