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
		$tpl = $this->container->get ( 'template' );
		$ftp = $this->container->get ( 'ftp' );
		
		$model = new \App\Models\FtpManager ( $ftp );
		$items = $model->listFolderContents ( '/HDD1' );
		logger ( '', $items );
		
		$tpl->assign ( array (
				'baseUrl' => $this->router ()->getBaseUrl (),
				'items' => $items,
				'flyoutContent' => '',
				'sidePanelContent' => '',
				'breadcrumbContent' => '' 
		) );
		
		$tpl->define ( array (
				"index" => "layouts/default.html",
				"head" => "layouts/head.html",
				"mainmenu" => "layouts/mainmenu.html",
				"sidepanel_flyout" => "",
				"sidenavi" => "",
				"body" => "partials/body.html",
				"toolbar" => "partials/toolbar.html",
				"upload_progress" => "partials/upload_progress.html",
				"left_sidebar" => "partials/left_sidebar.html",
				"folder_toolbar" => "partials/folder_toolbar.html",
				"item_list" => "partials/item_list.html",
				"right_sidebar" => "partials/right_sidebar.html",
				"bottom_toolbar" => "partials/bottom_toolbar.html",
				"new_folder_form" => "partials/new_folder_form.html",
				"flash_messages" => "" 
		) );
		
		$tpl->print_ ( 'index' );
	}
}