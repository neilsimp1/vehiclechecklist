<?php
		
	require_once 'User.php';

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
					$employee->lists = $row['EMPLOYEE_LISTS']? $row['EMPLOYEE_LISTS']: '<em>Nothing</em>';
					$employee->completedtoday = $row['EMPLOYEE_COMPLETEDTODAY'] !== null? $row['EMPLOYEE_COMPLETEDTODAY']: '100%';
					array_push($this->employees, $employee);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
		
	}
	
	class Employee extends User{
		
		public $err;
		public $lists, $completedtoday;
		
		public function __construct(){
			parent::__construct();
			$this->lists = [];
		}


		public function get($con){
		    $sql_query = sql_getEmployee($con, $this->id);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);

		        foreach($result as $row){
		            $this->name = $row['USER_NAME'];
		            $this->un = $row['USER_UN'];

					$sql_query = sql_getEmployeesLists($con, $this->id, date('Y-m-d'));
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);
						foreach($result as $row){
							$list = new CheckList();
							$list->id = $row['LIST_ID'];
							$list->name = $row['LIST_NAME'];
							array_push($this->lists, $list);
						}
					}
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
		
		public function save($con){
		    $sql_query = sql_addEmployee($con, $this);
		    $sql_query->execute();
		    $this->id = $sql_query->insert_id;
		}

		public function addList($con, $listID){
		    $sql_query = sql_addEmployeesList($con, $this->id, $listID);
		    $sql_query->execute();
		}
		
		public function removeList($con, $listID){
		    $sql_query = sql_deleteEmployeesList($con, $this->id, $listID);
		    $sql_query->execute();
		}

		public function delete($con){
		    $sql_queries = sql_deleteEmployee($con, $this->id);
			foreach($sql_queries as $sql_query){
				if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
			}
		}
		
	}
	
?>