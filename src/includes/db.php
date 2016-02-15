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
	
	function refValues($arr){
        $refs = array();
        foreach($arr as $key => $value) $refs[$key] = &$arr[$key];
        return $refs;
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
		$sql_query = $con->prepare(
			"SELECT U.USER_ID, U.USER_NAME, U.USER_UN
				,(SELECT LTRIM(GROUP_CONCAT(' ', L.LIST_NAME)) FROM LIST L
					WHERE L.LIST_ID IN(
						SELECT LU.LIST_ID FROM LIST_USER_JCT LU
                        WHERE U.USER_ID = LU.USER_ID
					)
				) EMPLOYEE_LISTS
			FROM USER U
			WHERE U.USER_GRP = 2;"
		);

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
	
	function sql_deleteEmployee($con, $employeeID){
		$queries = array(
			"DELETE FROM LISTITEM_USER_JCT WHERE USER_ID = ?;"
			,"DELETE FROM LIST_USER_JCT WHERE USER_ID = ?;"
			,"DELETE FROM USER WHERE USER_ID = ?;"
		);

		$sql_queries = array(
            $con->prepare($queries[0])
            ,$con->prepare($queries[1])
            ,$con->prepare($queries[2])
        );

		for($i = 0; $i < count($sql_queries); $i++){
			$_employeeID = []; $types = '';
			$qCount = substr_count($queries[$i], '?');
			for($j = 0; $j < $qCount; $j++) array_push($_employeeID, $employeeID);
			foreach($_employeeID as $id) $types .= 'i';
			$_employeeID = array_merge(array($types), $_employeeID);
			if($qCount > 0) call_user_func_array(array($sql_queries[$i], 'bind_param'), refValues($_employeeID));
        }

        return $sql_queries;
	}
	
	//checklist
	function sql_getChecklists($con, $userID){
		$sql_query = $con->prepare(
			"SELECT L.LIST_ID, L.LIST_NAME
				,(SELECT COUNT(*) FROM LIST_USER_JCT LU WHERE LU.LIST_ID = L.LIST_ID) LIST_NUMASSIGNED
			FROM LIST L
				LEFT JOIN LIST_USER_JCT LU ON L.LIST_ID = LU.LIST_ID
			WHERE LU.USER_ID LIKE ?;"
		);

		$sql_query->bind_param('s', $userID);

        return $sql_query;
	}

	function sql_getChecklist($con, $listID){
		$sql_query = $con->prepare(
			"SELECT L.LIST_ID, L.LIST_NAME
				,(SELECT COUNT(*) FROM LIST_USER_JCT LU WHERE LU.LIST_ID = L.LIST_ID) LIST_NUMASSIGNED
				,(SELECT GROUP_CONCAT(' ', U.USER_NAME) FROM USER U WHERE U.USER_ID IN(
					SELECT LU.USER_ID FROM LIST_USER_JCT LU WHERE LU.LIST_ID = L.LIST_ID
				)) LIST_EMPLOYEES
			FROM LIST L
			WHERE L.LIST_ID = ?;"
		);
		$sql_query->bind_param('i', $listID);

        return $sql_query;
	}

	function sql_addChecklist($con, $item){
		$sql_query = $con->prepare("INSERT INTO LIST(LIST_NAME) VALUES(?);");
		$sql_query->bind_param('s', $item->name);
		
		return $sql_query;
	}

	function sql_checkChecklistItem($con, $item){
		$sql_query = $con->prepare(
			"INSERT INTO LISTITEM_USER_JCT(LISTITEM_ID, USER_ID, LISTITEM_DONE, LISTITEM_DTE)
			VALUES(?,?,?,?)
			ON DUPLICATE KEY UPDATE LISTITEM_DONE = ?;"
		);
		$sql_query->bind_param('iiisi', $item->id, $item->userid, $item->done, $item->date, $item->done);
		
		return $sql_query;
	}

	function sql_deleteChecklist($con, $listID){
		$queries = array(
			"DELETE FROM LISTITEM WHERE LIST_ID = ?;"
			,"DELETE FROM LIST WHERE LIST_ID = ?;"
		);

		$sql_queries = array(
            $con->prepare($queries[0])
            ,$con->prepare($queries[1])
        );

		for($i = 0; $i < count($sql_queries); $i++){
            $_listID = []; $types = '';
            $qCount = substr_count($queries[$i], '?');
            for($j = 0; $j < $qCount; $j++) array_push($_listID, $listID);
            foreach($_listID as $id) $types .= 'i';
            $_listID = array_merge(array($types), $_listID);
            if($qCount > 0) call_user_func_array(array($sql_queries[$i], 'bind_param'), refValues($_listID));
        }

        return $sql_queries;
	}
	

	
	//checklistitem
	function sql_getChecklistItems($con, $list){
		$queryStr = "SELECT LI.LISTITEM_ID, LISTITEM_DESC ";
		if(isset($list->userid)) $queryStr.= ",(SELECT LUJ.LISTITEM_DONE FROM LISTITEM_USER_JCT LUJ WHERE LUJ.LISTITEM_ID = LI.LISTITEM_ID AND LUJ.USER_ID = ? AND LUJ.LISTITEM_DTE = ?) LISTITEM_DONE ";
		$queryStr .= "FROM LISTITEM LI WHERE LI.LIST_ID = ?;";
		
		$sql_query = $con->prepare($queryStr);

		if(isset($list->userid)) $sql_query->bind_param('iss', $list->userid, $list->date, $list->id);
		else $sql_query->bind_param('i', $list->id);

        return $sql_query;
	}
	
	function sql_addChecklistItem($con, $item){
		$sql_query = $con->prepare("INSERT INTO LISTITEM(LIST_ID, LISTITEM_DESC) VALUES(?,?);");
		$sql_query->bind_param('is', $item->listid, $item->desc);
		
		return $sql_query;
	}

	function sql_deleteChecklistItem($con, $itemID){
		$sql_query = $con->prepare("DELETE FROM LISTITEM WHERE LISTITEM_ID = ?;");
		$sql_query->bind_param('i', $itemID);
		
		return $sql_query;
	}
?>