<?php
	
	//Imports
	require_once 'db.php';
	require_once 'Checklist.php';
	require_once 'ChecklistItem.php';
	
	if(empty($_POST['name'])){header("Location: ../addchecklist?e=name"); exit;}
	
	$name = $_POST['name'];
	$descs = explode('|^|', $_POST['itemdescs']);
	
	$con = connect_db();

	$list = new Checklist();
	$list->name = $_POST['name'];
	$list->save($con);

	if($descs[0] != ''){
		foreach($descs as $desc){
			$listItem = new ChecklistItem();
			$listItem->listid = $list->id;
			$listItem->desc = $desc;
			$listItem->save($con);
		}
	}
	
	$con->close();
	
	header('Location: ../checklist?_='.$list->id);
	
?>