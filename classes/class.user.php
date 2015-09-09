<?php

include('class.password.php');

class User extends Password{

    private $db;
	//WORKS TO ADD _DB AS A CHILD TO ALL CLASSES USING CONSTRUCT
	
	function __construct($db){
		parent::__construct();
	
		$this->_db = $db;
	}

	//STARTS A SESSION (SERVER SIDE) TO TRACK THE USER IS LOGGED IN
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}		
	}
	
	//FINDING A USER BY THE HASHED PASS
	private function get_user_hash($username){	

		try {

			$stmt = $this->_db->prepare('SELECT password FROM CMS_users WHERE username = :username');
			$stmt->execute(array('username' => $username));
			
			$row = $stmt->fetch();
			return $row['password'];

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}

	//LOGIN, SELF EXPLANATORY, USES HASH
	public function login($username,$password){	

		$hashed = $this->get_user_hash($username);
		
		if($this->password_verify($password,$hashed) == 1){
		    
		    $_SESSION['loggedin'] = true;
		    return true;
		}		
	}
	
		
	public function logout(){
		session_destroy();
	}
	
}


?>