<?php
use \Kaiser\Controller;
use \Kaiser\Exception\ApplicationException;
use \App\Models\FtpLibraryItem;
/**
 */
class manager extends Controller {
	protected function requireLogin() {
		return false;
	}
	function execute() {
	}
	function upload() {
		logger ( $_POST );
		
		$config = $this->container->get ( 'config' );
		$ftp = $this->container->get ( 'ftp' );
		
		$path = $this->getParameter ( 'path', '/' );
		
		// $this->debug ( $_FILES ['file_data'] );
		
		$upload = new \Kaiser\Plupload ( $config->get ( 'plupload' ) );
		
		$upload->no_cache_headers ();
		$upload->cors_headers ();
		
		if (($file = $upload->getFiles ()) !== false) {
			$model = new \App\Models\FtpManager ( $ftp );
			
			$model->upload ( $path, $file );
		} else {
			$this->err ( $upload->get_error_message () );
		}
	}
	function onGoToFolder() {
		logger ( $_POST );
		
		$path = $this->getParameter ( 'path' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$model->setCurrentFolder ( $path );
		$var = $model->prepareVars ();
		
		//
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		$tpl->define ( "folder_path", "partials/folder_path.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ),
				'#MediaManager-manager-folder-path' => $tpl->fetch ( "folder_path" ) 
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
		
		//
		$tpl = $this->container->get ( 'template' );
		
		$tpl->assign ( $var );

		$tpl->define ( "item_list", "partials/item_list.html" );
		$tpl->define ( "filters", "partials/filters.html" );

		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ),
				'#MediaManager-manager-filters' => $tpl->fetch ( "filters" ) 
		];
	}
	public function onDelete() {
		logger ( $_POST );
		
		$paths = $this->getParameter ( 'paths' );
		
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
		$tpl->define ( "item_list", "partials/item_list.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ) 
		];
	}
	function onCreateFolder() {
		logger ( $_POST );
		
		$name = $this->getParameter ( 'name' );
		$path = $this->getParameter ( 'path' );
		
		if (! strlen ( $name )) {
			throw new ApplicationException ( '이름은 비워 둘 수 없습니다.' );
		}
		// if (! $this->validateFileName ( $name )) {
		// throw new ApplicationException ( '이름은 숫자 라틴 문자, 공백, ._-로 구성된 않으면 안됩니다.' );
		// }
		
		$newFolderPath = rtrim ( $path, '/' ) . '/' . ltrim ( $name, '/' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$model->mkdir ( $path, $newFolderPath );
		
		//
		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ) 
		];
	}
	function onSetSorting() {
		logger ( $_POST );
		
		$sortBy = $this->getParameter ( 'sortBy' );
		$path = $this->getParameter ( 'path' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$model->setSortBy ( $sortBy );
		$model->setCurrentFolder ( $path );
		
		$var = $model->prepareVars ();
		
		//
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		$tpl->define ( "folder_path", "partials/folder_path.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ),
				'#MediaManager-manager-folder-path' => $tpl->fetch ( "folder_path" ) 
		];
	}
	function onChangeView() {
		logger ( $_POST );
		
		$viewMode = $this->getParameter ( 'view' );
		$path = $this->getParameter ( 'path' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$model->setViewMode ( $viewMode );
		$model->setCurrentFolder ( $path );
		
		$var = $model->prepareVars ();
		
		//
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		$tpl->define ( "folder_path", "partials/folder_path.html" );
		$tpl->define ( "view_mode_buttons", "partials/view_mode_buttons.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ),
				'#MediaManager-manager-folder-path' => $tpl->fetch ( "folder_path" ) ,
				'#MediaManager-manager-view-mode-buttons' => $tpl->fetch ( "view_mode_buttons" ) 
		];
	}
	public function onLoadMovePopup() {
		logger ( $_POST );
		
		$exclude = $this->getParameter ( 'exclude', [ ] );
		if (! is_array ( $exclude )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$folders = $model->listAllDirectories ( $exclude );
		
		$folderList = [ ];
		foreach ( $folders as $folder ) {
			$path = $folder;
			
			if ($folder == '/') {
			} else {
				$segments = explode ( '/', $folder );
				$basename = FtpLibraryItem::getInstance ()->getbasename ( $folder );
				$name = str_repeat ( '&nbsp;', (count ( $segments ) - 1) * 4 ) . $basename;
			}
			
			$folderList [$path] = $name;
		}
		
		// logger ( $folderList );
		
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( array (
				'folders' => $folderList 
		) );
		$tpl->define ( "move_form", "partials/move_form.html" );
		
		return $tpl->fetch ( "move_form" );
	}
	function onMoveItems() {
		logger ( $_POST );
		
		$dest = $this->getParameter ( 'dest' );
		$files = $this->getParameter ( 'files', [ ] );
		$folders = $this->getParameter ( 'folders', [ ] );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		foreach ( $files as $path ) {
			$model->moveFile ( $path, $dest . '/' . FtpLibraryItem::getInstance ()->getbasename ( $path ) );
		}
		
		foreach ( $folders as $path ) {
			$model->moveFolder ( $path, $dest . '/' . FtpLibraryItem::getInstance ()->getbasename ( $path ) );
		}
		
		//
		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ) 
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