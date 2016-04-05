<?php
use \Kaiser\Controller;
class Hello extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		echo 'hello world';
	}
}
