<?php

require "php/model/itemsModel.php";
class ApiController
{
	public function detailItem($id)
	{
		$dbItem = new ItemsModel();
		$pictureItems = $dbItem->listenerPictureItem($id);
		$reviewsItems = $dbItem->listenerReviewsItem($id);
		//echo json_encode(array("pictures"=>$pictureItems));
		echo json_encode(array("pictures"=>$pictureItems,"reviews"=>$reviewsItems));
	}
}

?>