<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db.php';
	require_once 'ChecklistItem.php';
	
	if(!isset($_POST['itemID']) || !is_numeric($_POST['itemID'])){http_response_code(422); echo 'Invalid item ID'; exit;}
	if(!isset($_POST['done'])){http_response_code(422); echo 'Something borked'; exit;}
		
	$con = connect_db();

	$listItem = new ChecklistItem();
	$listItem->id = intval($_POST['itemID']);
	$listItem->userid = $_SESSION['USER_ID'];
	$listItem->date = date('Y-m-d');
	$listItem->done = $_POST['done'] === 'true';
	$listItem->check($con);
	
	$con->close();
	
	http_response_code(200);
	
?>