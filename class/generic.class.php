<?php
class Generic{
	var $_db;
	var $_rs;
	var $_debug = false;
	
	function Generic(){
		$this->connect();
	}
	
	function escape_str($value){
		if(!is_numeric($value))
		 $value = '"'.addslashes(stripslashes($value)).'"';
		
		return $value;
	}
	
	function connect(){
		if(file_exists('config/my.conf.php')){
			include_once "config/my.conf.php";
		}else
			include_once "../config/my.conf.php";
		
		
		if(!$return = $this->_db = mysql_connect($config["db"]["host"], $config["db"]["login"], $config["db"]["password"])){
    		return false;
		}
		
		if(!$return = @mysql_select_db($config["db"]["base"], $this->_db)){
			return false;
		}	
    	return $return;
	}
	
	function execute($query){
		if($this->_debug)
			echo '<li style="background:black; color: white;">'.$query.'</li>';
		
		$this->_rs = mysql_query($query, $this->_db);
		
		$returnSelect = false;
		if($this->_rs){
			while($data = $this->FetchAssoc())
				if($data)
					$returnSelect[] = $data;
		} else{
			return false;
		}
		
		if($returnSelect){	
         	return $returnSelect;
		}else{
			return $this->lastId();
		}
		
		//return  $this->_rs;
	}
	
	function lastId(){
		return @mysql_insert_id();
	}

	function NumRows(){
		return @mysql_num_rows($this->_rs);
	}	

	function FetchAssoc(){
		if($this->NumRows() > 0)
			return @mysql_fetch_assoc($this->_rs);
		else
			return false;
	}
	
}


?>