<?php

require_once('../connection.php');

class UserModel{
	
	private $db;
	private $createuser;
	private $createavtivationcode;
	private $getuser;
	private $vertifycode;

	public function __construct(){
		$this->db = new DatabaseConnection();
		$this->createuser = $this->db->prepare_statement("INSERT INTO `USER` (email, password, salt) VALUES (?,?,?)");
		$this->createavtivationcode = $this->db->prepare_statement("INSERT INTO `User_activation` (user_id, activation_key,expire) VALUES (?,?,?)");
		$this->createuserinfo = $this->db->prepare_statement("INSERT INTO `User_Info` (user_id) VALUES (?)");
		$this->getuser = $this->db->prepare_statement("SELECT * FROM `USER` WHERE `email` = ?");
		// $this->vertifycode = $this->db->prepare_statement(
		// 	"SELECT `email` FROM `USER` WHERE `USER_ID` = (SELECT `USER_ID` FROM `USER_ACTIVATION` WHERE `activation_key` = ? LIMIT 1)"
		// );
		$this->vertifycode = $this->db->prepare_statement(
			"UPDATE `USER` SET `is_activated` = '1' WHERE `USER_ID` = (SELECT `USER_ID` FROM `USER_ACTIVATION` WHERE `activation_key` = ? LIMIT 1)"
		);

	}

	public function __destruct(){
		$this->createuser->close();
	}

	public function createuser($email,$password,$salt,$code){
		$this->createuser->bind_param("sss",$email,$password,$salt);
		$success = $this->createuser->execute();
		if($success == true){
			// Last insert id
			$last_pk = $this->db->last_insert_id();
			// Insert activation key
			$dateTime = date("Y-m-d H:i:s",strtotime("+24 hours"));
			$this->createavtivationcode->bind_param("sss",$last_pk,$code, $dateTime);
			$this->createavtivationcode->execute();
			// Insert userinfo
			$this->createuserinfo->bind_param("s",$last_pk);
			$this->createuserinfo->execute();
			return true;
		}else
			return false;

	}

	public function getuser($email){
		$user_array = array();
		$this->getuser->bind_param("s", $email);
		if($this->getuser->execute()){
			$this->getuser->bind_result($id, $email, $pass, $admin,$act, $postnum,$salt);
			$this->getuser->fetch();
			$user_array[] = array(
				'id' => $id,
				'email' => $email,
				'password' => $pass,
				'admin' => $admin,
				'activated' => $act,
				'postnum' => $postnum,
				'salt' => $salt,
			);
			if($id != NULL){
				return $user_array;
			}else{
				return NULL;
			}
		}
	}

	public function vertifycode($email,$code){

		$this->vertifycode->bind_param("s",$code);
		$this->vertifycode->execute();
		return $this->vertifycode->affected_rows;

	}

	public function updateuserinfo(){
		$query = "UPDATE  FROM `USER`";
		return $this->db->send_sql($query)->fetch_all(MYSQLI_ASSOC);
	}

	// Admin
	public function getalluser(){
		$query = "SELECT * FROM `USER`";
		return $this->db->send_sql($query)->fetch_all(MYSQLI_ASSOC);
	}


}

?>