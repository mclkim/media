<?php

namespace App\Models;

class FtpManager extends FtpLibrary {
	const FOLDER_ROOT = '/';
	const VIEW_MODE_GRID = 'grid';
	const VIEW_MODE_LIST = 'list';
	const VIEW_MODE_TILES = 'tiles';
	const SELECTION_MODE_NORMAL = 'normal';
	const SELECTION_MODE_FIXED_RATIO = 'fixed-ratio';
	const SELECTION_MODE_FIXED_SIZE = 'fixed-size';
	const FILTER_EVERYTHING = 'everything';
	public function prepareVars() {
		$folder = $this->getCurrentFolder ();
		$folder = $this->getCurrentFolder ();
		$viewMode = $this->getViewMode ();
		$filter = $this->getFilter ();
		$sortBy = $this->getSortBy ();
		$searchTerm = $this->getSearchTerm ();
		$searchMode = strlen ( $searchTerm ) > 0;		

if (! $searchMode)
		$items = $this->listFolderItems ( $folder, $filter, $sortBy );
else				
		$items = $this->findFiles ( $searchTerm, $filter, $sortBy );

		$breadcrumb = $this->breadcrumb ( $folder );
		
		// logger ( 'prepareVars' );
		// logger ( $folder, $items );
		// logger ( '', $breadcrumb );
		
		return array (
				'currentFolder' => $folder,
				'isRootFolder' => $folder == self::FOLDER_ROOT,
				'pathSegments' => null ,
'viewMode' => $viewMode ,
'thumbnailParams' => null ,
'currentFilter' => $filter ,
'sortBy' => $sortBy ,
'searchMode' => $searchMode ,
'searchTerm' => $searchTerm ,
'sidebarVisible' => null ,

				'items' => $items,
				'breadcrumb' => $breadcrumb,
				
		);
	}
	public function listFolderItems($folder, $filter, $sortBy) {
		$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
		
		return $this->listFolderContents ( $folder, $sortBy, $filter );
	}
	public function findFiles($searchTerm, $filter, $sortBy) {
		$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
		
		return $this->findFiles ( $searchTerm, $sortBy, $filter );
	}
	public function setCurrentFolder($folder) {
		$folder = self::validatePath ( $folder );
		
		$_SESSION ['current_folder'] = $folder;
	}
	public function getCurrentFolder() {
		return if_exists ( $_SESSION, 'current_folder', self::FOLDER_ROOT );
	}
	public function setFilter($filter) {
		if (! in_array ( $filter, [ 
				self::FILTER_EVERYTHING,
				FtpLibraryItem::FILE_TYPE_IMAGE,
				FtpLibraryItem::FILE_TYPE_AUDIO,
				FtpLibraryItem::FILE_TYPE_DOCUMENT,
				FtpLibraryItem::FILE_TYPE_VIDEO 
		] )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$_SESSION ['media_filter'] = $filter;
	}
	public function getFilter() {
		return if_exists ( $_SESSION, 'media_filter', self::FILTER_EVERYTHING );
	}
	protected function setSearchTerm($searchTerm) {
		$_SESSION ['Search_Term'] = trim ( $searchTerm );
	}
	protected function getSearchTerm() {
		return if_exists ( $_SESSION, 'Search_Term', null );
	}
	protected function setSortBy($sortBy) {
		if (! in_array ( $sortBy, [ 
				MediaLibrary::SORT_BY_NAME,
				MediaLibrary::SORT_BY_SIZE,
				MediaLibrary::SORT_BY_MODIFIED 
		] )) {
			throw new ApplicationException ( 'Invalid input data' );
		}
		
		$_SESSION ['media_sort_by'] = $sortBy;
	}
	protected function getSortBy() {
		return if_exists ( $_SESSION, 'media_sort_by', self::SORT_BY_NAME );
	}
	protected function getSelectionParams() {
	}
	protected function setSelectionParams($selectionMode, $selectionWidth, $selectionHeight) {
	}
	protected function setSidebarVisible($visible) {
	}
	protected function getSidebarVisible() {
	}
	protected function setViewMode($viewMode) {
		if (! in_array ( $viewMode, [ 
				self::VIEW_MODE_GRID,
				self::VIEW_MODE_LIST,
				self::VIEW_MODE_TILES 
		] ))
			throw new ApplicationException ( 'Invalid input data' );
		
		$_SESSION ['view_mode'] = $viewMode ;
	}
	protected function getViewMode() {
		return if_exists ( $_SESSION, 'view_mode', self::VIEW_MODE_GRID );
	}
	public function breadcrumb($path) {
		$path = self::validatePath ( $path, true );
		$path = explode ( '/', ltrim ( $path, '/' ) );
		
		$parent = '';
		foreach ( $path as $dir ) {
			$chunks [] = array (
					'dir' => $dir,
					'path' => $parent,
					'content' => $dir == '' ? 'Home' : $dir 
			);
			$parent = rtrim ( $parent, '/' ) . '/' . ltrim ( $dir, '/' );
		}
		return $chunks;
	}
	private function _settype($ext) {
		$text_types = array (
				'txt',
				'text',
				'php',
				'phps',
				'php4',
				'js',
				'css',
				'htm',
				'html',
				'phtml',
				'shtml',
				'log',
				'xml' 
		);
		return ( bool ) (in_array ( $ext, $text_types )) ? 'ascii' : 'binary';
	}
	function upload($path = '/', $file, $mode = 'auto') {
		$path = self::validatePath ( $path );
		
		// Set the mode if not specified
		if ($mode === 'auto') {
			$extension = pathinfo ( $file ['name'], PATHINFO_EXTENSION ) ?  : 'unknown';
			// Get the file extension so we can set the upload type
			$mode = $this->_settype ( $extension );
		}
		
		try {
			$this->ftp->chdir ( $path );
			$mode = ($mode === 'ascii') ? FTP_ASCII : FTP_BINARY;
			$this->ftp->put ( $file ['name'], $file ['tmp_name'], $mode );
		} catch ( Exception $e ) {
			throw new FtpException ( $e->getMessage () );
			return false;
		}
		return true;
	}
	function mkdir($path = '/', $directory) {
		$path = self::validatePath ( $path );
		
		try {
			$this->ftp->chdir ( $path );
			if ($this->ftp->isDir ( $directory ) == false)
				$this->ftp->mkdir ( $directory );
		} catch ( Exception $e ) {
			throw new FtpException ( $e->getMessage () );
			return false;
		}
		return true;
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
