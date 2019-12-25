<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getTemperatures()
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
    
    function getTemperature($ID=0)
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
	
	function AddTemperature()
	{
		global $conn;
		$temp = $_POST["TEMP"];
		
		echo $query="INSERT INTO temperature(TEMP) VALUES('".$temp."')";
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Temperature ajoutÈ avec succËs.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function updateTemperature($id)
	{
		global $conn;
		$data = json_decode(file_get_contents("php://input"),true);
		$name = $data["name"];
		$description = $data["description"];
		$price = $data["price"];
		$category = $data["category"];
		$created = 'NULL';
		$modified = date('Y-m-d H:i:s');
		$query="UPDATE produit SET name='".$name."', description='".$description."', price='".$price."', category_id='".$category."', created='".$created."', modified='".$modified."' WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Temperature mis ‡ jour avec succËs.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'…chec de la mise ‡ jour de Temperature. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteTemperature($id)
	{
		global $conn;
		$query = "DELETE FROM produit WHERE id=".$id;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Temperature supprimÈ avec succËs.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'La suppression de la Temperature a ÈchouÈ. '. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
    
    switch($request_method)
	{
		
		case 'GET':
			// Retrive Products
			if(!empty($_GET["ID"]))
			{
				$ID=intval($_GET["ID"]);
				getTemperature($ID);
			}
			else
			{
				getTemperatures();
			}
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
			
		case 'POST':
			// Ajouter un produit
			AddTemperature();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateTemperature($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteTemperature($id);
			break;

	}