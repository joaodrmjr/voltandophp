<?php


namespace App\Auth;


use App\Models\User;
use App\Models\UserSession;

class Auth {

	const SESSION = "user_id";
	const REMEMBER = "ruser";

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

		// remember
		if ($remember) {
			$hash = generateToken1();
			$uagent = userAgentNoVersion();
			$expiry = time()+60*60*24*30;
			setcookie(self::REMEMBER, $hash, $expiry, "/");
			UserSession::updateOrCreate(
				[ "user_id" => $user->id, "user_agent" => $uagent ],
				[ "session" => $hash, "expiry" => $expiry ]
			);
		}

		$rcookie = self::REMEMBER;
		if (isset($_COOKIE[$rcookie])) {
			$hash = $_COOKIE[$rcookie];
			setcookie($rcookie, null, time()-1, "/");
			UserSession::where("session", $hash)->where("user_agent", userAgentNoVersion())->delete();
		}

		// muda o id da sessao sempre que loga
		session_regenerate_id(true);
	}

	public function logout()
	{
		unset($_SESSION[self::SESSION]);
		$this->user = null;
		$this->state = self::NONE;
	}

	public function getError(): ?string
	{
		return $this->error;
	}
}