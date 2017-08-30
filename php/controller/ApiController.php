<?php

require "Controller.php";
class ApiController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function detailItem($id)
	{
		$pictureItems = $this->itemsModel->listenerPictureItem($id);
		$reviewsItems = $this->itemsModel->listenerReviewsItem($id);
		//sleep(5);
		echo json_encode(array("pictures"=>$pictureItems,"reviews"=>$reviewsItems));
	}

	public function searchItem()
	{
		$sql = "";
		$search = true;
		if(isset($_POST["price"]))
		{
			$sql .= " price BETWEEN ".$_POST["price"]." AND ";
			$search == true;
		}
		if(isset($_POST["categorie"]))
		{
			$sql .= " categories_idcategories = ".$_POST["categorie"]." AND ";
			$search == true;
		}
		$sql = substr($sql, 0, -4);
		if($search == false)
		{
			$sql = 1;
		}
		$items = $this->itemsModel->select("*", "items", $sql);
		echo json_encode($items);
	}
}

?>