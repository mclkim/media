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
		$viewMode = $this->getViewMode ();
		$filter = $this->getFilter ();
		$sortBy = $this->getSortBy ();
		$searchTerm = $this->getSearchTerm ();
		$searchMode = strlen ( $searchTerm ) > 0;
		
		if (! $searchMode)
			$items = $this->listFolderItems ( $folder, $filter, $sortBy );
		else
			$items = $this->findFiles ( $searchTerm, $filter, $sortBy );
		
		return array (
				'items' => $items ,
				'currentFolder' => $folder,
				'isRootFolder' => $folder == self::FOLDER_ROOT,
				'pathSegments' => $this->splitPathToSegments ( $folder ),
				'viewMode' => $viewMode,
				'thumbnailParams' => null,
				'currentFilter' => $filter,
				'sortBy' => $sortBy,
				'searchMode' => $searchMode,
				'searchTerm' => $searchTerm,
				'sidebarVisible' => null,
		);
	}
	protected function listFolderItems($folder, $filter, $sortBy) {
		$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
		
		return $this->listFolderContents ( $folder, $sortBy, $filter );
	}
	protected function findItems($searchTerm, $filter, $sortBy) {
	$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
	
	return $this->findFiles ( $searchTerm, $sortBy, $filter );
	}
	public function setCurrentFolder($folder) {
		$folder = self::validatePath ( $folder );
		
		$_SESSION ['current_folder'] = $folder;
	}
	protected function getCurrentFolder() {
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
	protected function getFilter() {
		return if_exists ( $_SESSION, 'media_filter', self::FILTER_EVERYTHING );
	}
	public function setSearchTerm($searchTerm) {
		$_SESSION ['search_term'] = trim ( $searchTerm );
	}
	protected function getSearchTerm() {
		return if_exists ( $_SESSION, 'search_term', null );
	}
	public function setSortBy($sortBy) {
		if (! in_array ( $sortBy, [ 
				self::SORT_BY_NAME,
				self::SORT_BY_SIZE,
				self::SORT_BY_MODIFIED 
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
	public function setSelectionParams($selectionMode, $selectionWidth, $selectionHeight) {
	}
	public function setSidebarVisible($visible) {
		$_SESSION ['sidebar_visible'] = ! ! $visible;		
	}
	protected function getSidebarVisible() {
		return if_exists ( $_SESSION, 'sidebar_visible', true );
	}
	public function setViewMode($viewMode) {
		if (! in_array ( $viewMode, [ 
				self::VIEW_MODE_GRID,
				self::VIEW_MODE_LIST,
				self::VIEW_MODE_TILES 
		] ))
			throw new ApplicationException ( 'Invalid input data' );
		
		$_SESSION ['view_mode'] = $viewMode;
	}
	protected function getViewMode() {
		return if_exists ( $_SESSION, 'view_mode', self::VIEW_MODE_GRID );
	}
	protected function splitPathToSegments($path) {
		$path = self::validatePath ( $path, true );
		$path = explode ( '/', ltrim ( $path, '/' ) );
		
		$result = [ ];
		while ( count ( $path ) > 0 ) {
			$folder = array_pop ( $path );
			
			$result [$folder] = implode ( '/', $path ) . '/' . $folder;
			if (substr ( $result [$folder], 0, 1 ) != '/')
				$result [$folder] = '/' . $result [$folder];
		}

		return array_reverse ( $result );
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
