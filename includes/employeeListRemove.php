<?php
	
	//Imports
	require_once 'db.php';
	require_once 'Employee.php';
	
	if(!isset($_POST['userID']) || !is_numeric($_POST['userID'])){http_response_code(422); echo 'Invalid user ID'; exit;}
	if(!isset($_POST['listID']) || !is_numeric($_POST['listID'])){http_response_code(422); echo 'Invalid list ID'; exit;}
		
	$con = connect_db();

	$employee = new Employee();
	$employee->id = intval($_POST['userID']);
	$employee->removeList($con, intval($_POST['listID']));	
	
	$con->close();
	
	http_response_code(200);
	
?>