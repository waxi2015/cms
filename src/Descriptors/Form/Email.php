<?php

namespace App\Descriptors\Form;

class Email {
	
	public static function descriptor () {
		return array(
			'id' => 'email-confirmation',
			'permission' => 'admin',
			'after' => [
				[
					'class' => '\Email',
					'method' => 'sendOut',
				]
			],
			'elements' => [
				[
					'type' => 'tags',
					'name' => 'recipients',
					'label' => 'cms.emails.send_label_recipients',
					'required' => true,
				],
				[
					'name' => 'subject',
					'placeholder' => 'cms.emails.send_label_subject',
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
					'message' => 'cms.emails.send_success'
				],
				'false' => [
					'valid' => false,
					'message' => 'cms.emails.send_error',
				]
			],
			'data' => [
				'success' => 'waxcms.closeConfirmEmail'
			]
		);
	}
}