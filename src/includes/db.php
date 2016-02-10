<?php
    
    $db_conf = getDBConf();
    define('DB_SERVER', $db_conf[0]);
    define('DB_USER', $db_conf[1]);
    define('DB_PWD', $db_conf[2]);
    define('DB_NAME', $db_conf[3]);
	
    function connect_db(){
		$con = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
		if($con->connect_errno > 0)
			die('Unable to connect to database [' . $con->connect_error . ']');
		
		$con->set_charset("utf8");
		
		return $con;
	}
	
    function getDBConf(){
        $db_conf = [];
        $handle = fopen(!strpos(getcwd(), 'includes')? '../../protected/db_vcl': '../../../protected/db_vcl', 'r');
        if($handle){
            while(($line = fgets($handle)) !== false) array_push($db_conf, rtrim($line));
            fclose($handle);
        }
        else die('Unable to get database credentials');

        return $db_conf;
    }
	
	function sql_get_assoc($sql_query){
	    $meta = $sql_query->result_metadata();

	    while($field = $meta->fetch_field()) $params[] = &$row[$field->name];

	    call_user_func_array(array($sql_query, 'bind_result'), $params);
	    $result = [];
	    while($sql_query->fetch()){
	        foreach($row as $key => $val) $c[$key] = $val;
	        $result[] = $c;
	    }
	    $sql_query->close();

	    return $result;
	}
	
	
	
	
	//user
	function sql_getUser($con, $id){
		$sql_query = $con->prepare("SELECT USER_ID, USER_GRP, USER_NAME, USER_UN FROM USER WHERE USER_ID = ?;");

        $sql_query->bind_param('i', $id);

        return $sql_query;
	}
	
	function sql_login_check($con, $un, $pw){
		$sql_query = $con->prepare("SELECT USER_ID, USER_GRP, USER_NAME, USER_UN FROM USER WHERE USER_UN = ? AND USER_PW = ?;");

        $sql_query->bind_param('ss', $un, $pw);

        return $sql_query;
	}
	
	
	//employee
	function sql_getEmployees($con){
		$sql_query = $con->prepare("SELECT USER_ID, USER_NAME, USER_UN FROM USER WHERE USER_GRP = 2;");

        return $sql_query;
	}
	
	function sql_getEmployee($con, $userID){
		$sql_query = $con->prepare("SELECT USER_NAME, USER_UN FROM USER WHERE USER_ID = ?;");
		$sql_query->bind_param('i', $userID);

        return $sql_query;
	}
	
	function sql_getEmployeesLists($con, $userID){
		$sql_query = $con->prepare(
			"SELECT LU.LIST_ID, L.LIST_NAME
			FROM LIST_USER_JCT LU
				LEFT JOIN LIST L ON LU.LIST_ID = L.LIST_ID
			WHERE LU.USER_ID = ?;"
		);
		$sql_query->bind_param('i', $userID);

        return $sql_query;
	}
	
	function sql_addEmployee($con, $employee){
        $sql_query = $con->prepare("INSERT INTO USER(USER_GRP, USER_NAME, USER_UN, USER_PW) VALUES(?,?,?,?);");
		$sql_query->bind_param('isss', $employee->grp, $employee->name, $employee->un, $employee->pw);
		
		return $sql_query;
    }
	
	function sql_addEmployeesList($con, $employeeID, $listID){
        $sql_query = $con->prepare("INSERT INTO LIST_USER_JCT(LIST_ID, USER_ID) VALUES(?,?);");
		$sql_query->bind_param('ii', $listID, $employeeID);
		
		return $sql_query;
    }
	
	function sql_deleteEmployeesList($con, $employeeID, $listID){
		$sql_query = $con->prepare("DELETE FROM LIST_USER_JCT WHERE LIST_ID = ? AND USER_ID = ?;");
		$sql_query->bind_param('ii', $listID, $employeeID);
		
		return $sql_query;
    }
	
	
	//list
	function sql_getLists($con){
		$sql_query = $con->prepare("SELECT LIST_ID, LIST_NAME FROM LIST;");

        return $sql_query;
	}
	
?>