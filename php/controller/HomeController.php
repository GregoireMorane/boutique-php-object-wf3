<?php

require "Controller.php";
class HomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function home()
	{
		//var_dump($this->itemsModel);die();
		$itemsHome = $this->itemsModel->showItems();
		include("home.php");
	}
}

?>