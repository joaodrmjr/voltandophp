<?php


namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

	protected $errors;

	public function validate($request, array $rules)
	{

		foreach ($rules as $field => $rule) {
			try {
				$rule->setName(ucfirst($field))->assert($request->getParam($field));
			} catch (NestedValidationException $e) {
				$this->errors[$field] = $e->getMessages();
			}
		}

		$_SESSION["errors"] = $this->errors;

		return $this;


	}


	public function failed(): bool
	{
		return !empty($this->errors);
	}

	public function first()
	{
		return reset($this->errors)[0];
	}

}