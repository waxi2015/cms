<?php

namespace App\Converters;

class Emails {

	public function adminsBefore ($data, $params, &$form) {
		$password = substr(md5(rand()),0,6);

		$data['password'] = bcrypt($password);

		$data['nosave'] = [
			'password' => $password
		];

		return $data;
	}

	public function adminsAfter ($data, $params, &$form) {
		$emails = [];

		$email = $data['email'];
		$name = $data['firstname'] . ' ' . $data['lastname'];
		$password = json_decode($data['nosave'],true)['password'];

		$emails[] = [
			'to' => [
				[
					'name' => $name,
					'email' => $email,
				]
			],
			'params' => [
				'password' => $password,
				'url' => env('APP_URL') . '/admin',
			],
			'email' => 'add-administrator'
		];

		$this->_addFeedbackToForm($form, $emails);

		return true;
	}

	protected static function _getAdmins ($keyValue = true) {
		$admins = to_array(\DB::table('admins')
			->where('status', 1)
			->where('role', 'admin')
			->orderBy('firstname', 'ASC')
			->get());

		$adminTos = [];
		foreach ($admins as $admin) {
			if ($keyValue) {
				$adminTos[$admin['email']] = $admin['firstname'] . ' ' . $admin['lastname'];
			} else {
				$adminTos[] = [
					'name' => $admin['firstname'] . ' ' . $admin['lastname'],
					'email' => $admin['email'],
				];
			}

		}

		return $adminTos;
	}

	protected function _addFeedbackToForm ($form, $emails) {
		if (empty($emails)) {
			return;
		}

		if (!isset($form->feedback)) {
			$form->feedback = [
				'true' => [
					'valid' => true,
					'message' => \Lang::get('cms.form.save_success_msg'),
					'params' => [
						'emails' => $emails
					],
					'after' => ['waxcms.confirmEmail']
				]
			];
		} else {
			if (!isset($form->feedback['true'])) {
				$form->feedback['true'] = [
					'message' => \Lang::get('cms.form.save_success_msg')
				];
			}

			if (!isset($form->feedback['true']['params'])) {
				$form->feedback['true']['params'] = [];
			}

			if (!isset($form->feedback['true']['after'])) {
				$form->feedback['true']['after'] = [];
			}
		}

		$form->feedback['true']['after'][] = 'waxcms.confirmEmail';

		$form->feedback['true']['params']['emails'] = $emails;
	}
}