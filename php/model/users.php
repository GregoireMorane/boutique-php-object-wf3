<?php

require "model.php";
class Users extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function addUser($user = array())
	{
		if(!isset($user['firstname']))
		{
			return 0;
		}
		elseif(!isset($user['lastname']))
		{
			return 0;
		}
		elseif(!isset($user['email']))
		{
			return 0;
		}
		elseif(!isset($user['password']))
		{
			return 0;
		}

		return $this->insert($user, "clients");
	}

	public function addCategories($categorie = array())
	{
		if(!isset($categorie['name']))
		{
			return 0;
		}

		$this->insert($categorie, "categories");
	}

	public function addDelivery($delivery = array())
	{
		if(!isset($delivery['street']))
		{
			return 0;
		}
		elseif(!isset($delivery['city']))
		{
			return 0;
		}
		elseif(!isset($delivery['country']))
		{
			return 0;
		}
		elseif(!isset($delivery['type']))
		{
			return 0;
		}
		elseif(!isset($delivery['clients_idclients']))
		{
			return 0;
		}

		$this->insert($delivery, "delivery");
	}

	public function showDelivery($userId, $type = null)
	{
		if(!is_int($userId))
		{
			return 0;
		}
		if($type == null)
		{
			$sDeli = $this->select("*", "delivery", array("clients_idclients" => $userId));
		}
		else
		{
			$sDeli = $this->select("*", "delivery", array("clients_idclients" => $userId, "type" => $type));
		}
		var_dump($sDeli);
	}

	public function addFav($fav = array())
	{
		if(!is_int($fav['clients_idclients']))
		{
			return 0;
		}
		elseif(!is_int($fav['items_iditems']))
		{
			return 0;
		}
		$idFav = $this->insert($fav, "clients_has_items");
	}

	public function showFav($userId)
	{
		if(!is_int($userId))
		{
			return 0;
		}
		$myFav = $this->select("*", "showFav", array("idclients" => $userId));
		//var_dump($myFav);
	}
	/** REQUETE SQL SELECT equivalent INNER JOIN ON
	SELECT i.*, c.idclients
	FROM items i, clients c, clients_has_items chi 
	WHERE chi.items_iditems = iditems AND chi.clients_idclients = c.idclients
	**/

	public function showClientByEmail($email)
	{
		$user = $this->select("*", "clients", array("email" => $email));
		return $user;
	}

	public function addOrder($userId, $deliveryId){
		if(!is_int($userId)){
			return 0;
		}
		elseif(!is_int($deliveryId)){
			return 0;
		}
		$order = array('num_order'=> $this->random());
		$order["clients_idclients"] = $userId;
		$order["delivery_iddelivery"] = $deliveryId;
		$idOrder = $this->insert( $order, "orders" );
	}

	public function showOrders($userId)
	{
		if(!is_int($userId))
		{
			return 0;
		}
		$myOrders = $this->select("*", "orders", array("clients_idclients" => $userId));
		var_dump($myOrders);
	}

	/********************FONCTION RANDOM************************/

	private function random()
	{
		return "#".substr(md5(uniqid("User", true)), 10);
	}

}

//$test = new Users();
//$test->addUser(array('firstname'=>'TEST', 'lastname'=>'TEST', 'email'=>'greg@greg.com', 'password'=>'greg'));
//$test->addCategories(array('name'=>'Thé'));
//$test->addFav(array('clients_idclients'=> 1, 'items_iditems'=> 3));
//$test->showFav(1);
//$test->addDelivery(array('street'=>'Test1', 'city'=>'Test1.2', 'country'=>'Test1.3', 'type'=>'Test1.4', 'clients_idclients'=>1));
//$test->showDelivery(1, "Livraisons");
//$test->addOrder(1,1);
//$test->showOrders(1);

?>