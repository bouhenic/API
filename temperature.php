<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM TEMPERATURE";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
    function getProduct($ID=0)
	{
		global $conn;
		$query = "SELECT * FROM TEMPERATURE";
		if($ID != 0)
		{
			$query .= " WHERE ID=".$ID." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
    switch($request_method)
	{
		
		case 'GET':
			// Retrive Products
			if(!empty($_GET["ID"]))
			{
				$ID=intval($_GET["ID"]);
				getProduct($ID);
			}
			else
			{
				getProducts();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		/*case 'POST':
			// Ajouter un produit
			AddProduct();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateProduct($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteProduct($id);
			break;*/

	}