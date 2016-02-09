<?php
	
	//Imports
	require_once 'db.php';
	require_once 'Employee.php';
	
	if(empty($_POST['name'])){header("Location: ../?e=name"); exit;}
	if(empty($_POST['un'])){header("Location: ../?e=un"); exit;}
	if(empty($_POST['pw'])){header("Location: ../?e=pw"); exit;}
	
	$name = $_POST['name'];
	$un = $_POST['un'];
	$pw = md5($_POST['pw']);
	
	$con = connect_db();

	$employee = new Employee();
	$employee->grp = 2;
	$employee->name = $name;
	$employee->un = $un;
	$employee->pw = $pw;
	$employee->lists = explode(',', $_POST['listids']);
	$employee->save($con);

	foreach($employee->lists as $listID) $employee->addList($con, $listID);	
	
	$con->close();
	
	header('Location: ../employee?_='.$employee->id);
	
?>