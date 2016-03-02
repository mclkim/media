<?php
use \Kaiser\Controller;
use \Kaiser\Exception\ApplicationException;
/**
 */
class manager extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
	}
	function upload() {
		$config = $this->container->get ( 'config' );
		$ftp = $this->container->get ( 'ftp' );
		
		// logger ( $_POST );
		// logger ( $_FILES );
		
		$path = $this->getParameter ( 'path', '/' );
		
		// $this->debug ( $_FILES ['file_data'] );
		
		$upload = new \Kaiser\Plupload ( $config->get ( 'plupload' ) );
		
		$upload->no_cache_headers ();
		$upload->cors_headers ();
		
		if (($file = $upload->getFiles ()) !== false) {
			// $this->debug ( $file );
			
			$model = new \App\Models\FtpManager ( $ftp );
			
			$model->upload ( $path, $file );
		} else {
			$this->err ( $upload->get_error_message () );
		}
	}
	function onGoToFolder() {
		// logger ( base_path () );
		$path = $this->getParameter ( 'path' );
		
		// logger ( 'onGoToFolder' );
		// logger ( $path );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$model->setCurrentFolder ( $path );
		$var = $model->prepareVars ();
		
		// $ftp = $this->container->get ( 'ftp' );
		// $model = new \App\Models\FtpManager ( $ftp );
		// $model->setCurrentFolder ( $path );
		
		// $folder = $model->getCurrentFolder ();
		// $items = $model->listFolderContents ( $folder );
		// $breadcrumb = $model->breadcrumb ( $folder);
		
		//
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );
		$tpl->define ( array (
				"index" => "partials/item_list.html" 
		) );
		$itemlist = $tpl->fetch ( "index" );
		
		//
		$tpl->assign ( $var );
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
		logger ( $_POST );
	}
	public function onSetFilter() {
		logger ( $_POST );

$filter = $this->getParameter ( 'filter' );
$path = $this->getParameter ( 'path' );	

		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );

		$model->setFilter ( $filter );
		$model->setCurrentFolder ( $path );

		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );
		$tpl->define ( array (
				"index" => "partials/item_list.html" 
		) );
		$itemlist = $tpl->fetch ( "index" );
		
		return [ 
				'#MediaManager-manager-item-list' => $itemlist 
		];		
	}
	public function onDelete() {
		logger ( $_POST );
		
		$paths = $this->getParameter ( 'paths' );
		logger ( $paths );
		
		if (! is_array ( $paths )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$filesToDelete = [ ];
		foreach ( $paths as $pathInfo ) {
			if (! isset ( $pathInfo ['path'] ) || ! isset ( $pathInfo ['type'] )) {
				throw new ApplicationException ( 'Invalid input data' );
			}
			
			if ($pathInfo ['type'] == 'file') {
				$filesToDelete [] = $pathInfo ['path'];
			} else if ($pathInfo ['type'] == 'folder') {
				$model->deleteFolder ( $pathInfo ['path'] );
			}
		}
		
		if (count ( $filesToDelete ) > 0)
			$model->deleteFiles ( $filesToDelete );
		
		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );
		$tpl->define ( array (
				"index" => "partials/item_list.html" 
		) );
		$itemlist = $tpl->fetch ( "index" );
		
		return [ 
				'#MediaManager-manager-item-list' => $itemlist 
		];
	}
	function onCreateFolder() {
		logger ( $_POST );
		
		$name = $this->getParameter ( 'name' );
		$path = $this->getParameter ( 'path' );
		logger ( $name );
		logger ( $path );
		
		if (! strlen ( $name )) {
			throw new ApplicationException ( '이름은 비워 둘 수 없습니다.' );
		}		
// 		if (! $this->validateFileName ( $name )) {
// 			throw new ApplicationException ( '이름은 숫자 라틴 문자, 공백, ._-로 구성된 않으면 안됩니다.' );
// 		}		
		
		$newFolderPath = rtrim ( $path, '/' ) . '/' . ltrim ( $name, '/' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$model->mkdir ( $path, $newFolderPath );
		//
		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );
		$tpl->define ( array (
				"index" => "partials/item_list.html"
		) );
		$itemlist = $tpl->fetch ( "index" );
		
		return [
				'#MediaManager-manager-item-list' => $itemlist
		];		
	}
	protected function validateFileName($name) {
		if (! preg_match ( '/^[0-9a-z\.\s_\-]+$/i', $name )) {
			return false;
		}
	
		if (strpos ( $name, '..' ) !== false) {
			return false;
		}
	
		return true;
	}
}