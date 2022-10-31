<?php


namespace App\Auth;


use App\Models\User;

class Auth {


	const NONE = 0;
	const LOGGED = 1;
	const ADMIN = 2;


	protected $container;

	protected $state, $user;



	public function __construct($container)
	{
		$this->container = $container;


		// verifica o estado
		$this->check();
	}


	public function check(): void
	{
		$userId = $_SESSION['user_id'] ?? null;
		if ($userId && $user = User::find($userId)) {
			$this->user = $user;
			$this->state = $user->admin ? self::LOGGED : self::LOGGED;
			return;
		}

		$this->user = null;
		$this->state = self::NONE;
	}

	public function state(): int
	{
		return $this->state;
	}

	// este ? é para retornar um user ou NULL
	public function user(): ?User
	{
		return $this->user;
	}
}