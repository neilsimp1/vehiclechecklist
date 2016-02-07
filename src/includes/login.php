<?php
	
	//Imports
	require_once 'db.php';
	require_once 'User.php';
	
	if(empty($_POST['un'])){header("Location: ../?e=un"); exit;} 
	if(empty($_POST['pw'])){header("Location: ../?e=pw"); exit;}
	
	$un = $_POST['un'];
	$pw = md5($_POST['pw']);
		
	$con = connect_db();

	$sql_query = sql_login_check($con, $un, $pw);
	if($sql_query->execute()){
		$sql_query->store_result();
		$result = sql_get_assoc($sql_query);

		foreach($result as $row){
			$user = new User();
			$user->id = intval($row['USER_ID']);
			$user->grp = intval($row['USER_GRP']);
			$user->name = $row['USER_NAME'];
			$user->un = $row['USER_UN'];
		}
	}
	else die('There was an error running the query ['.$con->error.']');
	
	$con->close();
	
	//If no user, exit
	if(!isset($user)){header('Location: ../?e=l'); exit;}
	
	//Start session
	session_set_cookie_params(0);
	session_start();
	$_SESSION['USER_ID'] = $user->id;
	$_SESSION['USER_GRP'] = $user->grp;
	$_SESSION['USER_NAME'] = $user->name;
	$_SESSION['USER_UN'] = $user->un;
	
	header('Location: ../');
	
?>