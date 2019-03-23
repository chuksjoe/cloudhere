<?php
	class User{
		public $user_id;
		protected $firstname;
		protected $lastname;
		protected $email;
		protected $street;
		protected $city;
		protected $state;
		protected $country;
		protected $zip;
		protected $phone;
		public $gender;
		public $dob;
		public $dateLastLogin;
		public $isLoggedIn = false;
		public $loggedOut = false;
		public $usedStorage;
		
		function __construct(){
			if(session_id() == ''){
				session_start();
			}
			if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true){
				$this->_initUser();
			}
		}//end of constructor
		
		function getID(){
			if(session_id() == ''){
				session_start();
			}
			//if($this->isLoggedIn){
				return $user_id;
			//}
		}//End of getID function
		
		public function authenticate($email, $pass){
			if(session_id() == ''){
				session_start();
			}
			$_SESSION['isLoggedIn'] = false;
			$this->isLoggedIn = false;
			$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
			//check for successful connection to the database
			if($mysqli->connect_errno){
				error_log("Cannot connect to MYSQL: ".$mysqli->connect_error);
				return false;
			}
			$safeUser = $mysqli->real_escape_string($email);
			$enteredPassW = $mysqli->real_escape_string($pass);
			$query = "SELECT * from tbl_user where email = '{$safeUser}'";
			if(!$result = $mysqli->query($query)){
				error_log("Cannot retrieve account for {$email}");
				return false;
			}
			//if the above query succeeds the password is checked
			$row = $result->fetch_assoc();
			$storedPassW = $row['password'];
			//check if the entered password matches the entered password
			if(crypt($enteredPassW, $storedPassW) != $storedPassW){
				error_log("Password for {$email} doesn't match");
				return false;
			}
			//if the passwords match, the following is executed
			$this->user_id = $row['user_id'];
			$this->firstname = $row['first_name'];
			$this->lastname = $row['last_name'];
			$this->email = $row['email'];
			$this->street = $row['street'];
			$this->city = $row['city'];
			$this->state = $row['state'];
			$this->country = $row['country'];
			$this->zip = $row['zip'];
			$this->phone = $row['phone'];
			$this->gender = $row['gender'];
			$this->dob = $row['dob'];
			$this->dateLastLogin = $row['date_last_online'];
			$this->isLoggedIn = true;
			
			$this->_setSession();
			return true;
		}//End of Authenticate function
		
		private function _setSession(){
			if(session_id() == ''){
				session_start();
			}
			//set the session variables from the User object properties
			$_SESSION['user_id'] = $this->user_id;
			$_SESSION['email'] = $this->email;
			$_SESSION['firstname'] = $this->firstname;
			$_SESSION['lastname'] = $this->lastname;
			$_SESSION['street'] = $this->street;
			$_SESSION['city'] = $this->city;
			$_SESSION['state'] = $this->state;
			$_SESSION['country'] = $this->country;
			$_SESSION['zip'] = $this->zip;
			$_SESSION['gender'] = $this->gender;
			$_SESSION['phone'] = $this->phone;
			$_SESSION['dob'] = $this->dob;
			$_SESSION['lastLogin'] = $this->dateLastLogin;
			$_SESSION['isLoggedIn'] = $this->isLoggedIn;
		}//End of setSession Function
		
		private function _initUser(){
			if(session_id() == ''){
				session_start();
			}
			//setting up the user object properties with the SESSION content
			$this->user_id = $_SESSION['user_id'];
			$this->email = $_SESSION['email'];
			$this->firstname = $_SESSION['firstname'];
			$this->lastname = $_SESSION['lastname'];
			$this->street = $_SESSION['street'];
			$this->city = $_SESSION['city'];
			$this->state = $_SESSION['state'];
			$this->country = $_SESSION['country'];
			$this->zip = $_SESSION['zip'];
			$this->phone = $_SESSION['phone'];
			$this->gender = $_SESSION['gender'];
			$this->dob = $_SESSION['dob'];
			$this->dateLastLogin = $_SESSION['lastLogin'];
			$this->isLoggedIn = $_SESSION['isLoggedIn'];
		}//End of initUser function
		
		public function lastLogin($email){
			if(session_id() == ''){
				session_start();
			}
			$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
			//check for successful connection to the database
			if($mysqli->connect_errno){
				error_log("Cannot connect to MYSQL: ".$mysqli->connect_error);
				return false;
			}
			$date = date("Y-m-d G:i:s");
			$query = "UPDATE tbl_user SET date_last_online = '{$date}' WHERE email = '{$email}'";
			if(!$result = $mysqli->query($query)){
				error_log("Cannot Update account for {$email}");
				return false;
			}
		}//End of lastLogin function
		
		public function updateUserDetails(){
			$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
			//check for successful connection to the database
			if($mysqli->connect_errno){
				error_log("Cannot connect to MYSQL: ".$mysqli->connect_error);
				return false;
			}
			/*$safeUser = $mysqli->real_escape_string($email);
			$enteredPassW = $mysqli->real_escape_string($pass);*/
			$query = "SELECT * from tbl_user where email = '{$this->email}'";
			if(!$result = $mysqli->query($query)){
				error_log("Cannot retrieve account for {$email}");
				return false;
			}
			//if the above query succeeds the password is checked
			$row = $result->fetch_assoc();
			$this->user_id = $row['user_id'];
			$this->firstname = $row['first_name'];
			$this->lastname = $row['last_name'];
			$this->email = $row['email'];
			$this->street = $row['street'];
			$this->city = $row['city'];
			$this->state = $row['state'];
			$this->country = $row['country'];
			$this->zip = $row['zip'];
			$this->phone = $row['phone'];
			$this->gender = $row['gender'];
			$this->dob = $row['dob'];
			$this->dateLastLogin = $row['date_last_online'];
			$this->isLoggedIn = true;
			
			$this->_setSession();
			return true;
		}//end of updateUserDetails() function
		
		public function logout(){
			$this->isLoggedIn = false;
			
			if(session_id() == ''){
				session_start();
			}
			$_SESSION['isLoggedIn'] = false;
			foreach($_SESSION as $keys => $value){
				$_SESSION[$keys] = "";
				unset($_SESSION[$keys]);
			}
			
			$_SESSION = array();
			if(ini_get("session.use_cookies")){
				$cookieParameters = session_get_cookie_params();
				setcookie(session_name(), '', time() - 28800, $cookieParameters['path'], $cookieParameters['domain'], $cookieParameters['secure'], $cookieParameters['httponly']);
			}
			session_destroy();
		}//End of Logout function
	}//End of User Class
?>