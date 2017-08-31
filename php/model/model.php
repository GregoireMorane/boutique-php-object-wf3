<?php

class Model // CreateReadUpdateDelete
{
	private $host;
	private $user;
	private $password;
	public $database;
	protected $pdo;

	function __construct($host = "", $database = "", $user = "", $password = "")
	{
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->password = DB_PASSWORD;
		$this->database = DB_NAME;
		$this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}

	public function select($champs = "*", $table = "", $where = 1)
	{
		$theChamps = $this->arrayToString($champs);
		$theWhere = $this->arrayToString($where, "update");
		$result = $this->pdo->query("SELECT $theChamps FROM $table WHERE $theWhere");
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectJoin($champs, $table, $x, $table2 , $on ,$where = 1)
	{
		$theChamps = $this->arrayToString($champs);
		$theWhere = $this->arrayToString($where, "update");
		$result = $this->pdo->query("SELECT $theChamps FROM $table $x JOIN $table2 ON $on WHERE $theWhere");
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($champs, $table = '')
	{
		$theChamps ="";
		$theNewChamps = array();
		$point =""; 
		if(is_array($champs))
		{
			foreach($champs as $key => $value)
			{
				$theChamps .= trim($key).',';
				array_push($theNewChamps, trim($value));
				$point .= "?,";
			}
			$theChamps = substr($theChamps,0,-1);
			$point = substr($point,0,-1);
		}
		else
		{
			$theChamps = $champs;
		}

		try
		{
			$result = $this->pdo->prepare("INSERT INTO $table ($theChamps) VALUES ($point)");
			$result->execute($theNewChamps);
			return $this->pdo->lastInsertId();
		}
		catch(Exception $e)
		{
			return -1;
		}
	}

	public function delete($champs, $table)
	{
		$theChamps = $this->arrayToString($champs, "delete");
		$result = $this->pdo->exec("DELETE FROM $table WHERE $theChamps");
	}

	public function update($champs, $x, $table)
	{
		$theChamps = $this->arrayToString($champs, "update");
		$theX = $this->arrayToString($x, "update");
		$result = $this->pdo->exec("UPDATE $table SET $theChamps WHERE $theX");
	}

// ***************** FONCTION ARRAYTOSTRING **************************

	private function arrayToString($champs, $type = "select")
	{
		$theChamps = "";
		if(is_array($champs))
		{
			if($type == "select")
			{
				foreach($champs as $value)
				{
					$theChamps = $theChamps . $value . ',';
				}
			}
			elseif($type == "update" || $type == "delete")
			{
				foreach($champs as $key => $valeur)
				{
					$theChamps = $theChamps . $key . " = '" . $valeur . "' AND ";
				}
				$theChamps = substr($theChamps,0,-4);
			}
			elseif($type == 4)
			{
				foreach($champs as $key => $valeur)
				{
					$theChamps = $theChamps . $key . " = '" . $valeur . "',";
				}
			}
			else
			{
				foreach($champs as $value)
				{
					$theChamps = $theChamps . "'" . $value . "',";
				}
			}
			$theChamps = substr($theChamps,0,-1); 
		}
		else
		{
			$theChamps = $champs;
		}
		return $theChamps;
	}

}

//$bd = new Model("localhost", "myshop", "root", "");
//$bd->select(array("nom", "prenom"), "users");
//$bd->insert(array("nom","prenom"), array("Morane","Greg"), "users");
//$bd->delete(array("id"=>"7"), "users");
//$bd->update(array("nom"=>"Morane"), array("id"=>"4"), "users");
//public function selectJoin($champs, $table, $x, $table2 , $on ,$where = 1)
//$test = $bd->selectJoin(array("*"), "clients_has_items", "INNER", "clients", "clients_has_items.clients_idclients = clients.idclients", array("clients.idclients"=>2));
//var_dump($test);

?>