<?php

require "model.php";
class ItemsModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function addItem($item = array())
	{
		if(!isset($item['libelle']))
		{
			return 0;
		}
		elseif(!isset($item['description']))
		{
			return 0;
		}
		elseif(!isset($item['code_item']))
		{
			return 0;
		}
		elseif(!isset($item['stocks']))
		{
			return 0;
		}
		elseif(!isset($item['availabity']))
		{
			return 0;
		}
		elseif(!isset($item['price']))
		{
			return 0;
		}

		$this->insert($item, "items");
	}
	
	public function supprItem($item = array())
	{
		$this->delete($item, "items");
	}

	public function updateItem($item = array(), $iditem = array())
	{
		$this->update($item, $iditem, "items");
	}

	public function addItemIntoOrder($orderId, $itemId, $qte)
	{
		if(!is_int($orderId))
		{
			return 0;
		}
		elseif(!is_int($itemId))
		{
			return 0;
		}

		$price = $this->select("price", "items", array("iditems"=>$itemId));
		$priceTotal = $price[0]["price"] * $qte;
		$priceTotal = number_format($priceTotal, 2, '.', '');
		$idFavorie = $this->insert( array("orders_idorders"=>$orderId, "items_iditems"=>$itemId, "price_final"=>$priceTotal, "qte"=>$qte), "orders_has_items" );
	}

	public function supprItemIntoOrder($item = array())
	{
		$this->delete($item, "orders_has_items");
	}

	public function addPicture($item = array())
	{
		$this->insert($item, "pictures");
	}

	public function showPic($itemId)
	{
		$myPictures = $this->select("*", "pictures", array("items_iditems" => $itemId));
		var_dump($myPictures);
	}

	public function listenerPictureItem($id)
	{
		if(!is_int($id))
		{
			return -1;
		}
		return $this->select("url", "pictures", array("items_iditems" => $id));
	}

	public function listenerReviewsItem($id)
	{
		if(!is_int($id))
		{
			return -1;
		}
		return $this->select("note, commentaire, CONCAT(firstname, ' ' ,lastname) as username", "reviews, clients", "items_iditems = $id AND clients_idclients = idclients");
	}

	public function showItems($nbItem = 8)
	{
		if(!is_int($nbItem))
		{
			return -1;
		}
		return $this->select( "i.*, p.url", "`pictures` p, items i", "p.`items_iditems` = i.iditems GROUP BY i.iditems LIMIT ".$nbItem );
	}

	public function listItem($id)
	{
		if(!is_int($id))
		{
			return -1;
		}

		return $this->select("i.*, c.name as categories", "items i, categories c", "i.`categories_idcategories` = c.idcategories AND i.iditems = ".$id." GROUP BY i.iditems");
	}

	public function listCategories()
	{
		return $this->select("name", "categories");
	}

}

// $test = new ItemsModel();
// var_dump($test->showItems());
//$test->addItem(array('libelle'=>'Test2', 'description'=>'Test2.2', 'code_item'=>'Test2.3', 'stocks'=>4, 'availabity'=>'Test1.5', 'price'=>7, 'categories_idcategories'=>3));
//$test->supprItem(array('libelle'=>'Test2'));
//$test->addItemIntoOrder(11, 4 , 5);
//$test->addPicture(array("name" => "picture2", "url" => "http://geexfiles.com/wp-content/uploads/2016/12/Robo-270x320.jpg", "date_create" => "22/08/2017", "items_iditems" => 2));
//$test->showPic(3);
//$test->updateItem(array("description"=>"sylvestre"), array("iditems"=>3));

// SELECT i.*, c.name as categories, p.url, AVG(r.note) as reviewsMoyen FROM items i, categories c, pictures p, reviews r WHERE i.`categories_idcategories` = c.idcategories AND i.iditems = p.items_iditems AND r.items_iditems = i.iditems AND i.iditems = 2 GROUP BY i.iditems
//SELECT i.* p.url FROM pictures p, items i WHERE p.items_iditems = i.iditems GROUP BY i.iditems LIMIT 8
?>