<?php

namespace Demo;

use \Kaiser\Controller;

class Hello extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		phpinfo ();
	}
}
