<?php
	
	//Imports
	require_once 'includes/session.php';
	require_once 'includes/db.php';
	require_once 'includes/Employee.php';
	require_once 'includes/List.php';

	if($_SESSION['USER_GRP'] !== 1){header('Location: ./'); exit;}
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])){header('Location: ./'); exit;}

	$con = connect_db();

	$employee = new Employee();
	$employee->id = intval($_GET['_']);
	$employee->get($con);

	if($employee->un == ''){header('Location: ./'); exit;}

	$lists = new Checklists();
	$lists->get($con);
	
	$con->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Check List</title>
	
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet" />	

	<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="js/script.js" defer="defer"></script>
</head>
<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/employee.php'; ?>
	<?php include 'templates/footer.php'; ?>
</body>
</html>