<?php


namespace App\Validation\Exceptions;


use Respect\Validation\Exceptions\ValidationException;

class PasswdMatchException extends ValidationException {

	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => "As senhas inseridas não conferem."
		]
	];

}