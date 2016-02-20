<?php
	
	class Report{
		
		public $err;
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

					$sql_query = sql_getChecklists($con, $employee->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);
				
						foreach($result as $row){
							$list = new Checklist();
							$list->id = $row['LIST_ID'];
							$list->name = $row['LIST_NAME'];
							$list->userid = $employee->id;

							$sql_query = sql_getChecklistItems($con, $list);
							if($sql_query->execute()){
								$sql_query->store_result();
								$result = sql_get_assoc($sql_query);
								foreach($result as $row){
									$item = new ChecklistItem();
									$item->id = $row['LISTITEM_ID'];
									$item->desc = $row['LISTITEM_DESC'];
									$item->done = $row['LISTITEM_DONE'];
									array_push($list->items, $item);
								}
							}
							else die('There was an error running the query ['.$con->error.']');

							array_push($employee->lists, $list);
						}
					}
					else die('There was an error running the query ['.$con->error.']');
					
					$completedToday = true;
					foreach($employee->lists as $list){
						foreach($list->items as $item){
							if(!$item->done) $completedToday = false;
						}
					}
					$employee->completedtoday = $completedToday? 'Yep': 'Nope';

					array_push($this->employees, $employee);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}

	}
	
?>