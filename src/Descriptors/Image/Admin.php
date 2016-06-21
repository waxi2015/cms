<?php

namespace App\Descriptors\Image;

class Admin {

	public $types = [
		'normal' => [
			'size' => [200,200,'crop'],
		],
		'form' => [
			'size' => [140,140,'crop'],
		],
		'thumbnail' => [
			'size' => [48,48,'crop'],
		]
	];
}