<?php
	
	class Employees{
		
		public $employees;

		public function __construct(){
		    $this->employees = [];
		}

		public function get($con){
		    $sql_query = sql_getEmployees($con);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);

		        foreach($result as $row){
		            $employee = new Employee();
		            $employee->id = $row['USER_ID'];
		            $employee->name = $row['USER_NAME'];
		            $employee->un = $row['USER_UN'];
					array_push($this->employees, $employee);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
	}
	
	class Employee extends User{
		
		public $err;
		public $completedtoday;
		
		public function __construct(){
			parent::__construct();	
			$this->completedtoday = false;
		}

		
		//public function isValid(){
		//    if(strlen($this->username) === 0 || strlen($this->username) > 45) $this->err .= 'u';
		//    if(strlen($this->name) === 0 || strlen($this->name) > 40) $this->err .= 'n';
		//    if(strlen($this->email) === 0 || strlen($this->email) > 50) $this->err .= 'e';
			
		//    if(strlen($this->err) > 0) return false;
		//    return true;
		//}

		//public function get($con){
		//    $sql_query = sql_getUser($con, $this->id);
		//    if($sql_query->execute()){
		//        $sql_query->store_result();
		//        $result = sql_get_assoc($sql_query);

		//        foreach($result as $row){
		//            $this->grp = intval($row['USER_GRP']);
		//            $this->name = $row['USER_NAME'];
		//            $this->un = $row['USER_UN'];
		//        }
		//    }
		//    else die('There was an error running the query ['.$con->error.']');
		//}

		//public function save($con){
		//    $sql_query = sql_addUser($con, $this);
		//    $sql_query->execute();
		//    $this->id = $sql_query->insert_id;
		//}

		//public function update($con){
		//    $sql_query = sql_updateUser($con, $this);
		//    $sql_query->execute();
		//}

		//public function updatePW($con){
		//    $sql_query = sql_updateUserPW($con, $this);
		//    $sql_query->execute();
		//}
		
	}
	
?>