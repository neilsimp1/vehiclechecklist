<?php
	
	class ChecklistItem{
		
		public $err;
		public $id, $listid, $desc, $donetoday, $date, $done;
		
		public function __construct(){
			
		}
		
		public function save($con){
		    $sql_query = sql_addChecklistItem($con, $this);
		    $sql_query->execute();
		    $this->id = $sql_query->insert_id;
		}
		
		public function check($con){
		    $sql_query = sql_checkChecklistItem($con, $this);
		    $sql_query->execute();
		    $this->id = $sql_query->insert_id;
		}

		public function delete($con){
		    $sql_query = sql_deleteChecklistItem($con, $this->id);
		    $sql_query->execute();
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