<?php



// funcao de exemplo
function sum($a, $b): int
{
	return $a + $b;
}


function userAgentNoVersion(): string
{
	$uagent = $_SERVER["HTTP_USER_AGENT"];
	$regx = "/\/[a-zA-Z0-9.]+/";
	return preg_replace($regx, '', $uagent);
}

function generateToken1(): string
{
	$token = openssl_random_pseudo_bytes(20);
	return bin2hex($token);
}

function getCsrfCode($csrf): string
{
	$nameKey = $csrf->getTokenNameKey();
	$valueKey = $csrf->getTokenValueKey();
	$name = $csrf->getTokenName();
	$value = $csrf->getTokenValue();

	return "
			<input class='csrf-name' type='hidden' name='{$nameKey}' value='{$name}'>
			<input class='csrf-val' type='hidden' name='{$valueKey}' value='{$value}'>
		";
}