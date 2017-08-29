<?php

//echo $_SERVER["REQUEST_URI"];die();
session_start();
require_once "php/config.php";

function recoveryLastElemToUrl()
{
	$statement = preg_split("(/)",$_SERVER["REQUEST_URI"]);
	$nbElem = sizeof(preg_split("(/)",FOLDER));
	$id = (sizeof($statement) > $nbElem)?$statement[$nbElem]:0;
	unset($statement[$nbElem]);
	$_SERVER["REQUEST_URI"] = implode("/",$statement);
	return $id;
}

$id = recoveryLastElemToUrl();

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	switch($_SERVER["REQUEST_URI"])
	{
		case FOLDER."user-register":
			require "php/controller/UserController.php";
			$userController = new UsersController();
			$userController->addUser();
		break;

		case FOLDER."single":
			require "php/controller/ApiController.php";
			$apiController = new ApiController();
			$apiController->detailItem((int)$id);
		break;

		case FOLDER."shop-list":
			require "php/controller/ApiController.php";
			$apiController = new ApiController();
			$apiController->searchItem();
		break;

		default:
			header("Location:".HOST.FOLDER."404");
	}
}

elseif($_SERVER["REQUEST_METHOD"] == "GET")
{

	switch($_SERVER["REQUEST_URI"])
	{
		case FOLDER:
			require "php/controller/HomeController.php";
			$home = new HomeController();
			$home->home();
		break;

		case FOLDER."logout":
			require "php/controller/UserController.php";
			$userController = new UsersController();
			$userController->logOutClient();
		break;

		case FOLDER."single":
			require "php/controller/singleShopController.php";
			$shop = new singleShopController();
			$shop->single((int)$id);
		break;

		case FOLDER."shop-list":
			require "php/controller/singleShopController.php";
			$shop = new singleShopController();
			$shop->shopListView();
		break;

		case FOLDER."404":
			require "php/Controller/controller.php";
			Controller::show404();
		break;

		default:
			header("Location:".HOST.FOLDER."404");
	}
}

?>