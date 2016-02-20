<?php
	
	//Imports
	require_once 'db.php';
	require_once 'ChecklistItem.php';
	
	if(!isset($_POST['itemID']) || !is_numeric($_POST['itemID'])){http_response_code(422); echo 'Invalid item ID'; exit;}
		
	$con = connect_db();

	$employee = new ChecklistItem();
	$employee->id = intval($_POST['itemID']);
	$employee->delete($con);	
	
	$con->close();
	
	http_response_code(200);
	
?>