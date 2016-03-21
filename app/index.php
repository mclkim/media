<?php
use \Kaiser\Controller;
/**
 * http://localhost/test/public/?index
 */
class index extends Controller {
	protected function requireLogin() {
		return true;
	}
	function execute() {
		$this->debug ( $_SESSION );
		// logger ( base_path () );
		
		$ftp = $this->container->get ( 'ftp' );
		
		$model = new \App\Models\FtpManager ( $ftp );
		$var = $model->prepareVars ();
		// $this->debug ( $var );
		
		//
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );
		
		$tpl->define ( array (
				"body" => "partials/body.html",
				"bottom_toolbar" => "partials/bottom_toolbar.html",
				"filters" => "partials/filters.html",
				"flash_messages" => "",
				"folder_path" => "partials/folder_path.html",
				"folder_toolbar" => "partials/folder_toolbar.html",
				"head" => "layouts/head.html",
				"index" => "layouts/default.html",
				"item_list" => "partials/item_list.html",
				"left_sidebar" => "partials/left_sidebar.html",
				"mainmenu" => "layouts/mainmenu.html",
				"new_folder_form" => "partials/new_folder_form.html",
				"right_sidebar" => "partials/right_sidebar.html",
				"sidenavi" => "",
				"sidepanel_flyout" => "",
				"sorting" => "partials/sorting.html",
				"toolbar" => "partials/toolbar.html",
				"upload_progress" => "partials/upload_progress.html",
				"view_mode_buttons" => "partials/view_mode_buttons.html" 
		) );
		
		$tpl->print_ ( 'index' );
		flush ();
	}
}