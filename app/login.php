<?php
use \Kaiser\Controller;
/**
 */
class login extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		echo 'hello world~~~';
	}
}