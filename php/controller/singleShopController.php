<?php

require "php/model/itemsModel.php";
class singleShopController
{
	public function single($id)
	{
		$dbItem = new ItemsModel();
		$itemsHome = $dbItem->listItem($id);
		if(sizeof($itemsHome) != 1)
		{
			header("Location:".HOST.FOLDER."404");
		}
		else
		{
			$itemsSingle = $dbItem->showItems($id);
			require "shop-single.php";
			echo "<script>let idItem = ".$itemsHome[0]["iditems"].";let typePage = 1;</script>";
		}
	}
}

?>