<?php
	
	//Imports
	require_once 'db.php';
	require_once 'ChecklistItem.php';
	
	if(!isset($_POST['listID']) || !is_numeric($_POST['listID'])){http_response_code(422); echo 'Invalid list ID'; exit;}
	if(!isset($_POST['desc']) || $_POST['desc'] == ''){http_response_code(422); echo 'Invalid description'; exit;}
	
	$con = connect_db();

	$listItem = new ChecklistItem();
	$listItem->listid = intval($_POST['listID']);
	$listItem->desc = $_POST['desc'];
	$listItem->save($con);
	
	$con->close();
	
	http_response_code(200);
	echo json_encode($listItem);
	
?>