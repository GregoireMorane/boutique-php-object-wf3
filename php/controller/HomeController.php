<?php

class HomeController
{
	public function home()
	{
		require "php/model/itemsModel.php";
		$dbItem = new ItemsModel();
		$itemsHome = $dbItem->showItems();
		include("home.php");
	}
}

?>