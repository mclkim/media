<?php
use \Kaiser\Controller;
use \Kaiser\Test;
class Hello extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		\Kaiser\Test::getInstance ()->test ();
	}
}
