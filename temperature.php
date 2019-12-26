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
				'status_message' =>'Temperature added with success.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERROR!.'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function updateTemperature($ID)
	{
		global $conn;
		$data = json_decode(file_get_contents("php://input"),true);
		$temp = $data["temp"];
		$query="UPDATE TEMPERATURE SET TEMP='".$temp."' WHERE id=".$ID;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Temperature updated with success.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Failure with the temperature update'. mysqli_error($conn)
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	function deleteTemperature($ID)
	{
		global $conn;
		$query = "DELETE FROM TEMPERATURE WHERE id=".$ID;
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Temperature deleted with success.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Failure with the suppression '. mysqli_error($conn)
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
			$id = intval($_GET["ID"]);
			updateTemperature($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["ID"]);
			deleteTemperature($id);
			break;

	}