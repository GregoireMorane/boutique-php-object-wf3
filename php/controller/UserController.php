<?php

require "php/model/users.php";

class UsersController
{
	public function addUser()
	{
		$redirect = 0;
		$error = $this->arrayIsEmpty($_POST, array("firstname", "lastname", "email", "password"));
		if($error == -1)
		{
			$redirect = -1;
		}

		if($redirect != -1)
		{
			$dbUser = new Users();
			$user = $dbUser->showClientByEmail($_POST['email']);
			
			if(count($user) >= 1)
			{
				$redirect = -1;
			}

			if($redirect != -1)
			{
				$_POST['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
				$Iduser = $dbUser->addUser($_POST);
			}
		}

		if($redirect == -1)
		{
			header('Location:'.HOST.FOLDER.'404');
		}
		else
		{
			$_POST["idclients"] = $Iduser;
			$this->clientAddSession($_POST);
			header('Location:'.HOST.FOLDER);
		}
	}

	public function arrayIsEmpty($data = array(), $keyObligatory = array())
	{
		if(!is_array($data))
		{
			return -1;
		}
		$isOk = false;
		foreach($data as $key => $val)
		{
			foreach($keyObligatory as $keyO => $valO)
			{
				if($keyO == $key)
				{
					$isOk = true;
				}
			}
			if(!$isOk || empty(trim($val)))
			{
				return -1;
			}
		}
		return 1;
	}

	public function clientAddSession($user = array())
	{
		if(!isset($user["idclients"]))
		{
			return -1;
		}
		unset($user["password"]);
		$_SESSION["User"] = $user;
	}

	public function logOutClient()
	{
		unset($_SESSION["user"]);
		header("Location:".HOST.FOLDER);
	}
}

?>