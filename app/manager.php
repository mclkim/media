<?php
use \Kaiser\Controller;
use \Kaiser\Exception\ApplicationException;
use \Kaiser\Exception\SystemException;
use \App\Models\FtpLibraryItem;
use \App\Models\FtpLibrary;
use \App\Models\FtpManager;
use Apfelbox\FileDownload\FileDownload;
/**
 */
class manager extends Controller {
	protected function requireLogin() {
		return true;
	}
	public function onUpload() {
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
			
			// $model->uploadFile ( $path, $file );
			if (! $model->uploadFile ( $path, $file )) {
				throw new SystemException ( 'Error saving remote file to a temporary location' );
			}
		} else {
			$this->err ( $upload->get_error_message () );
		}
	}
	public function onSearch() {
		logger ( $_POST );
		
		$search = $this->getParameter ( 'search' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$model->setSearchTerm ( $search );
		
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
	public function onGenerateThumbnails() {
		logger ( $_POST );
		
		$batch = $this->getParameter ( 'batch' );
		
		if (! is_array ( $batch )) {
			return;
		}
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$var = $model->prepareVars ();
		
		$result = [ ];
		$tpl = $this->container->get ( 'template' );
		$tpl->define ( "thumbnail_image", "partials/thumbnail_image.html" );
		$tpl->assign ( $var );
		foreach ( $batch as $thumbnailInfo ) {
			$tpl->assign ( $model->generateThumbnail ( $thumbnailInfo ) );
			
			$result [] = array (
					'id' => $thumbnailInfo ['id'],
					'markup' => $tpl->fetch ( "thumbnail_image" ) 
			);
		}
		
		return [ 
				'generatedThumbnails' => $result 
		];
	}
	public function onGetSidebarThumbnail() {
		logger ( $_POST );
		
		$path = $this->getParameter ( 'path' );
		$path = FtpLibrary::validatePath ( $path );
		
		$lastModified = $this->getParameter ( 'lastModified' );
		if (! is_numeric ( $lastModified )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		$thumbnailParams = $model->getThumbnailParams ();
		$thumbnailParams ['height'] = 255;
		$thumbnailParams ['width'] = 300;
		$thumbnailParams ['mode'] = 'auto';
		
		$thumbnailInfo = $thumbnailParams;
		$thumbnailInfo ['path'] = $path;
		$thumbnailInfo ['lastModified'] = $lastModified;
		$thumbnailInfo ['id'] = 'sidebar-thumbnail';
		
		$tpl = $this->container->get ( 'template' );
		$tpl->define ( "thumbnail_image", "partials/thumbnail_image.html" );
		$tpl->assign ( $model->generateThumbnail ( $thumbnailInfo, $thumbnailParams, true ) );
		
		return [ 
				'id' => $thumbnailInfo ['id'],
				'markup' => $tpl->fetch ( "thumbnail_image" ) 
		];
	}
	public function onChangeView() {
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
				'#MediaManager-manager-folder-path' => $tpl->fetch ( "folder_path" ),
				'#MediaManager-manager-view-mode-buttons' => $tpl->fetch ( "view_mode_buttons" ) 
		];
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
	public function onSetSorting() {
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
	public function onDownload() {
		logger ( $_POST );
		
		$paths = $this->getParameter ( 'paths' );
		
		if (! is_array ( $paths )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$filesToDownload = [ ];
		$folderToDownload = [ ];
		foreach ( $paths as $pathInfo ) {
			if (! isset ( $pathInfo ['path'] ) || ! isset ( $pathInfo ['type'] )) {
				throw new ApplicationException ( 'Invalid input data' );
			}
			
			if ($pathInfo ['type'] == 'file') {
				$filesToDownload [] = $pathInfo ['path'];
			} else if ($pathInfo ['type'] == 'folder') {
				$folderToDownload [] = $pathInfo ['path'];
			}
		}
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		if (count ( $folderToDownload ) > 0 || count ( $filesToDownload ) > 1) {
			// TODO::임시파일이름 지정
			$tempFilePath = $model->getLocalTempFilePath ();
			$zip = $model->zip ( $folderToDownload, $filesToDownload, $tempFilePath );
			
			$zipfile = $_SESSION ['data'] ['username'] . '-' . time () . '.zip';
			$fileDownload = FileDownload::createFromFilePath ( $tempFilePath );
			
			header ( 'Set-Cookie: fileDownload=true; path=/' );
			header ( 'Cache-Control: max-age=60, must-revalidate' );
			$fileDownload->sendDownload ( $zipfile );
		} else {
			// logger ( $folderToDownload );
			// logger ( $filesToDownload );
			$path = array_pop ( $filesToDownload );
			// logger ( $path );
			$filename = FtpLibraryItem::getInstance ()->getbasename ( $path );
			
			$tempFilePath = $model->getLocalTempFilePath ();
			if (! $model->downloadFile ( $path, $tempFilePath )) {
				throw new SystemException ( 'Error saving remote file to a temporary location' );
			}
			// logger ( $tempFilePath );
			// logger ( $filename );
			$fileDownload = FileDownload::createFromFilePath ( $tempFilePath );
			
			header ( 'Set-Cookie: fileDownload=true; path=/' );
			header ( 'Cache-Control: max-age=60, must-revalidate' );
			$fileDownload->sendDownload ( $filename );
		}
	}
	public function onLoadRenamePopup() {
		logger ( $_POST );
		
		$path = $this->getParameter ( 'path' );
		$type = $this->getParameter ( 'type' );
		
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( array (
				'originalPath' => $path,
				'name' => FtpLibraryItem::getInstance ()->getbasename ( $path ),
				'type' => $type 
		) );
		$tpl->define ( "rename_form", "partials/rename_form.html" );
		
		return $tpl->fetch ( "rename_form" );
	}
	public function onApplyName() {
		logger ( $_POST );
		
		$name = $this->getParameter ( 'name' );
		$originalPath = $this->getParameter ( 'originalPath' );
		
		$newName = trim ( $name );
		if (! strlen ( $newName )) {
			throw new ApplicationException ( '' );
		}
		
		// $originalPath = FtpLibrary::validatePath ( $originalPath );
		$newPath = dirname ( $originalPath ) . '/' . $newName;
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		
		if ($type == FtpLibraryItem::TYPE_FILE) {
			$model->moveFile ( $originalPath, $newPath );
		} else {
			$model->moveFolder ( $originalPath, $newPath );
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
	public function onCreateFolder() {
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
		$model->makeFolder ( $newFolderPath );
		
		//
		$var = $model->prepareVars ();
		
		$tpl = $this->container->get ( 'template' );
		$tpl->assign ( $var );
		$tpl->define ( "item_list", "partials/item_list.html" );
		
		return [ 
				'#MediaManager-manager-item-list' => $tpl->fetch ( "item_list" ) 
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
	public function onMoveItems() {
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
	public function onSetSidebarVisible() {
		logger ( $_POST );
		
		$visible = $this->getParameter ( 'visible' );
		
		$ftp = $this->container->get ( 'ftp' );
		$model = new \App\Models\FtpManager ( $ftp );
		$model->setSidebarVisible ( $visible );
	}
	public function onLoadPopup() {
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