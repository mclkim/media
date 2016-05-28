<?php
use \Kaiser\Controller;
use \Kaiser\Exception\AjaxException;
use \Kaiser\Response;
class login extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		$this->debug ( $_SESSION );
		
		$returnURI = $this->getParameter ( 'returnURI', $this->_defaultPage );
		
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( array (
				'csrf_token' => app ()->getCsrfToken (),
				'returnURI' => $returnURI,
				'userField' => 'user_id',
				'passField' => 'pass_wd' 
		) );
		
		$tpl->define ( array (
				"index" => "partials/login/index.html" 
		) );
		
		$tpl->print_ ( 'index' );
		flush ();
	}
	function auth() {
		logger ( $_POST );
		
		$returnURI = $this->getParameter ( 'returnURI', $this->_defaultPage );
		
		if (($username = $this->getParameter ( 'user_id' )) == false) {
			throw new AjaxException ( '아이디를 입력해 주세요.' );
		}
		if (($password = $this->getParameter ( 'pass_wd' )) == false) {
			throw new AjaxException ( '비밀번호를 입력해 주세요.' );
		}
		
		// $this->debug ( $username );
		
		try {
			$ftp = $this->container->get ( 'ftp' );
			$ftp->login ( $username, $password );
		} catch ( Exception $e ) {
			throw new AjaxException ( '아이디 또는 비밀번호가 일치하지 않습니다.' );
		}
		
		// $this->debug ( $password );
		
		$_SESSION ['user'] = array (
				'username' => $username,
				'password' => $password 
		);
		
		// $ret ['code'] = 1;
		// $ret ['value'] = rtrim ( $this->router ()->getBaseUrl ( true ), '/' ) . $returnURI;
		// echo json_encode ( $ret );
		
		$result = [ 
				'X_OCTOBER_REDIRECT' => $returnURI,
				'redirect' => rtrim ( $this->router ()->getBaseUrl ( true ), '/' ) . $returnURI 
		];
		return Response::getInstance ()->setContent ( $result );
	}
}