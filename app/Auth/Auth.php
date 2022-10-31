<?php


namespace App\Auth;


use App\Models\User;

class Auth {

	const SESSION = "user_id";

	const NONE = 0;
	const LOGGED = 1;
	const ADMIN = 2;


	protected $container;

	protected $state, $user;
	protected $error, $obj;


	public function __construct($container)
	{
		$this->container = $container;


		// verifica o estado
		$this->check();
	}


	public function check(): void
	{
		$userId = $_SESSION[self::SESSION] ?? null;
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

	public function tryLogin(array $params): bool
	{
		$username = $params["username"];
		$passwd = $params["password"];


		if (empty($username) || empty($passwd)) {
			$this->error = "É necessário preencher todos os campos para continuar.";
			return false;
		}

		if (!$user = User::where("username", $username)->orWhere("email", $username)->first()) {
			$this->error = "Nome de usuario ou Email não encontrado :/";
			return false;
		}

		if (!password_verify($passwd, $user->password)) {
			$this->error = "A senha inserida está incorreta.";
			return false;
		}

		$this->login($user, isset($params["remember"]));

		return true;
	}

	public function login(User $user, $remember = false)
	{
		$_SESSION[self::SESSION] = $user->id;
		$this->user = $user;
		$this->state = $user->admin ? self::ADMIN : self::LOGGED;

		// muda o id da sessao sempre que loga
		session_regenerate_id(true);
	}

	public function getError(): ?string
	{
		return $this->error;
	}
}