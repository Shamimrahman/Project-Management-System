<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include '../../config/db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users WHERE Email = '".$Email."' AND Password = '".md5($Password)."'");

		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'Password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 2;
		}
	}
	function logout(){
		session_destroy(); // Ends the current session 
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]); // Unsets each individual session variable
		}
		header("location:../views/login.php"); 
	}
	
	function save_user(){
		extract($_POST); //extract values from superglobal array
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('Id','cpass')) && !is_numeric($k)){
				if($k =='Password'){
					if(empty($v))
						continue;
					$v = md5($v); //password hashing

				}
				if(empty($data)){
					$data .= " $k='$v' "; // If $data is empty,the assignment is done directly. 
				}else{
					$data .= ", $k='$v' "; // a comma and space are added before appending the new key-value pair.
				}
			}
			}
	     //check duplicate email
		$check = $this->db->query("SELECT * FROM users where Email ='$Email' ".(!empty($Id) ? " and id != {$Id} " : ''))->num_rows;
		if($check > 0){
			return 2; //return 2 indicates found the duplicate email
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $name);
			$data .= ", Avatar = '$Name' ";

		}
		if(empty($Id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where Id = $Id");
		}

		if($save){
			// store relevant form data in the session
			if(empty($Id))
				$Id = $this->db->insert_id; 
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('Id','cpass','Password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $Id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $Name;
			return 1;
		}
	}

	function update_user(){
		extract($_POST); 
		$data = "";
		foreach($_POST as $k => $v){
			// check if key is not 'id', 'cpass', 'table', or 'password' and is not numeric
			if(!in_array($k, array('Id','cpass','table','Password')) && !is_numeric($k)){

				// build the data string for the update query
				if(empty($data)){
					$data .= " $k='$v' ";  
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
	
		$check = $this->db->query("SELECT * FROM users where Email ='$Email' ".(!empty($Id) ? " and Id != {$Id} " : ''))->num_rows;
		if($check > 0){
			return 1;  
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $Name);
			$data .= ", avatar = '$Name' ";

		}
		// handle password update
		if(!empty($Password))
			$data .= " ,Password=md5('$Password') ";

		// perform the update or insert query based on $id
		if(empty($Id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where Id = $Id");
		}

		if($save){
		// store relevant form data in the session
			foreach ($_POST as $key => $value) {
				if($key != 'Password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $Name;
			return 1; // return 1 to indicate successful update
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where Id = ".$Id);
		if($delete)
			return 1;
	}

	
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$Name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $Name);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$Name;
			}
		}
	}
	
	
	function save_project(){
		extract($_POST); // extract values from $_POST
		$data = ""; // Initializes an empty string to store the data for the query
		foreach($_POST as $k => $v){
			if(!in_array($k, array('Id','User_Ids')) && !is_numeric($k)){
				if($k == 'Description')
					$v = htmlentities(str_replace("'","&#x1430;",$v));
				if(empty($data)){
					$data .= " $k='$v' "; // If $data is empty,the assignment is done directly. 
				}else{
					$data .= ", $k='$v' "; // a comma and space are added before appending the new key-value pair.
				}
			}
		}
		if(isset($User_Ids)){
			$data .= ", User_Ids='".implode(',',$User_Ids)."' "; 
			//to concatenate the elements of the $user_ids array into a string, separated by commas.
			//the key is 'user_ids' and the value is the concatenated string of $user_ids array elements.
			// the $user_ids variable contains an array of user IDs associated with the project.
		}		
		if(empty($Id)){
			$save = $this->db->query("INSERT INTO project set $data");
		}else{
			$save = $this->db->query("UPDATE project set $data where Id = $Id");
		}
		if($save){
			return 1;
		}
	}
	function delete_project(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM project where Id = $Id");
		if($delete){
			return 1;
		}
	}
	function save_task(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'Description')
					$v = htmlentities(str_replace("'","&#x1430;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($Id)){
			$save = $this->db->query("INSERT INTO task set $data");
		}else{
			$save = $this->db->query("UPDATE task set $data where Id = $Id");
		}
		if($save){
			return 1;
		}
	}
	function delete_task(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_list where Id = $Id");
		if($delete){
			return 1;
		}
	}
	
}