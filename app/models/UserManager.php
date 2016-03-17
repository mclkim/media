<?php
interface Authentication {
	public function login($uuid, $pass);
	public function getError();
}
class UserManager implements Authentication {
	private $error = false; // defaults to false
	protected $ftp;
	public function __construct() {
	}
	protected function setUser($user) {
		$_SESSION ['login_user'] = $user;
	}
	public function getUser() {
		return if_exists ( $_SESSION, 'login_user', null );
	}
	protected function setPass($pass) {
		$_SESSION ['login_pass'] = $pass;
	}
	public function getPass() {
		return if_exists ( $_SESSION, 'login_pass', null );
	}
	public function login($user, $pass) {
		if ($this->password_verify ( $user, $pass )) {
			$this->setUser ( $user );
			$this->setPass ( $pass );
			
			return true;
		} else {
			$this->setError ( "Invalid username or password" );
		}
	}
	public function logout() {
		session_unset ();
		session_destroy ();
		unset ( $_SESSION );
	}
	protected function password_verify($username, $password) {
		if (empty ( $username ) || empty ( $password ))
			return false;
		
		try {
			$ret = $this->ftp->login ( $username, $password );
			return isset ( $ret ) ? $ret : false;
		} catch ( \Exception $e ) {
			return false;
		}
	}
	function setError($val) {
		$this->error = $val;
	}
	function getError() {
		return $this->error;
	}
}