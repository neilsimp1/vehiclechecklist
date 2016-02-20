<?php
	
	//Imports
	require_once 'db.php';
	require_once 'Employee.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){http_response_code(422); echo 'Invalid user ID'; exit;}
		
	$con = connect_db();

	$employee = new Employee();
	$employee->id = intval($_POST['id']);
	$employee->delete($con);	
	
	$con->close();
	
	header('Location: ../employees');
	
?>