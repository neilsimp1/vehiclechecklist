<?php
	
	class Checklists{
		
		public $lists;

		public function __construct(){
		    $this->lists = [];
		}

		public function get($con){
		    $sql_query = sql_getChecklists($con);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);
				
		        foreach($result as $row){
		            $list = new Checklist();
		            $list->id = $row['LIST_ID'];
		            $list->name = $row['LIST_NAME'];
		            $list->numassigned = $row['LIST_NUMASSIGNED'];
					array_push($this->lists, $list);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
	}
	
	class Checklist{
		
		public $err;
		public $id, $name, $items, $numassigned, $employees;
		
		public function __construct(){
			$this->items = [];
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
		
		public function get($con){
		    $sql_query = sql_getChecklist($con, $this->id);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);

		        foreach($result as $row){
		            $this->name = $row['LIST_NAME'];
					$this->numassigned = $row['LIST_NUMASSIGNED'];
					$this->employees = $row['LIST_EMPLOYEES'];

					$sql_query = sql_getChecklistItems($con, $this->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);
						foreach($result as $row){
							$item = new ChecklistItem();
							$item->id = $row['LISTITEM_ID'];
							$item->desc = $row['LISTITEM_DESC'];
							array_push($this->items, $item);
						}
					}
					else die('There was an error running the query ['.$con->error.']');
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
		
		public function save($con){
		    $sql_query = sql_addChecklist($con, $this);
		    $sql_query->execute();
		    $this->id = $sql_query->insert_id;
		}

		public function delete($con){
		    $sql_queries = sql_deleteChecklist($con, $this->id);
			foreach($sql_queries as $sql_query){
				if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
			}
		}

	}
	
?>