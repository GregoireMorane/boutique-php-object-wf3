<?php

require "Controller.php";
class singleShopController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function single($id)
	{
		$itemsHome = $this->itemsModel->listItem($id);
		if(sizeof($itemsHome) != 1)
		{
			header("Location:".HOST.FOLDER."404");
		}
		else
		{
			$itemsSingle = $this->itemsModel->showItems($id);
			require "shop-single.php";
			echo "<script>let idItem = ".$itemsHome[0]["iditems"].";let typePage = 1;</script>";
		}
	}
}

?>