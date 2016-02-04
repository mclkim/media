<?php
use \Kaiser\Controller;
/**
 */
class manager extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
	}
	public function onGoToFolder() {
		logger ( base_path() );

		$tpl = $this->container->get ( 'template' );
		
		$tpl->define ( array (
				"index" => "partials/item_list.html" 
		) );

		$itemlist = $tpl->fetch ( "index" );
		
		$tpl->define ( array (
				"index" => "partials/folder_path.html" 
		) );
		
		$folderpath = $tpl->fetch ( "index" );

		return [ 
				'#MediaManager-manager-item-list' => $itemlist,
				'#MediaManager-manager-folder-path' => $folderpath 
		];
	}
	public function onGetSidebarThumbnail() {
		;
	}
}