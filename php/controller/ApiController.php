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
		echo json_encode(array("pictures"=>$pictureItems,"reviews"=>$reviewsItems));
	}
}

?>