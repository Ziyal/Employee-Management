<?php
include('password.php');

class User extends Password{
    private $_db;
    function __construct($db){
    	parent::__construct();
    	$this->_db = $db;
    }
	private function get_user_hash($email){
		try {
			$stmt = $this->_db->prepare('SELECT email, password, id FROM users WHERE email = :email');
			$stmt->execute(array('email' => $email));
			return $stmt->fetch();
		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function isValidEmail($email) {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
		return true; 
	}

	public function login($email,$password){
		if (!$this->isValidEmail($email)) return false;
		if (strlen($password) < 3) return false;
		$row = $this->get_user_hash($email);
		if($this->password_verify($password,$row['password']) == 1){
		    $_SESSION['loggedin'] = true;
		    $_SESSION['email'] = $row['email'];
		    $_SESSION['id'] = $row['id'];
		    return true;
		}
	}
	public function logout(){
		session_destroy();
	}
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
}
?>