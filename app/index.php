<?php
use \Kaiser\Controller;
/**
 * http://localhost/test/public/?index
 */
class index extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
		$ftp = $this->container->get ( 'ftp' );
		
		$model = new \App\Models\FtpManager ( $ftp );
		$var = $model->prepareVars ();
		
		//
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( array (
				"index" => "layouts/default.html",
				"head" => "layouts/head.html",
				"mainmenu" => "layouts/mainmenu.html",
				"sidepanel_flyout" => "",
				"sidenavi" => "",
				"body" => "partials/body.html",
				"toolbar" => "partials/toolbar.html",
				"view_mode_buttons" => "partials/view_mode_buttons.html",
				"upload_progress" => "partials/upload_progress.html",
				"left_sidebar" => "partials/left_sidebar.html",
				"filters" => "partials/filters.html",
				"sorting" => "partials/sorting.html",
				"folder_toolbar" => "partials/folder_toolbar.html",
				"folder_path" => "partials/folder_path.html",
				"item_list" => "partials/item_list.html",
				"right_sidebar" => "partials/right_sidebar.html",
				"bottom_toolbar" => "partials/bottom_toolbar.html",
				"new_folder_form" => "partials/new_folder_form.html",
				"flash_messages" => "" 
		) );
		
		$tpl->print_ ( 'index' );
		flush ();
	}
}