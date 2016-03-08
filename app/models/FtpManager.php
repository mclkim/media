<?php

namespace App\Models;

use \Kaiser\Exception\ApplicationException;
use \Eventviva\ImageResize;

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
				'items' => $items,
				'currentFolder' => $folder,
				'isRootFolder' => $folder == self::FOLDER_ROOT,
				'pathSegments' => $this->splitPathToSegments ( $folder ),
				'viewMode' => $viewMode,
				'thumbnailParams' => null,
				'currentFilter' => $filter,
				'sortBy' => $sortBy,
				'searchMode' => $searchMode,
				'searchTerm' => $searchTerm,
				'sidebarVisible' => $this->getSidebarVisible () 
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
	function generateThumbnail($thumbnailInfo, $thumbnailParams = null) {
		$publicUrl = 'http://localhost//media/public/_thumbnail/';
		// $encoded = implode ( "/", array_map ( "rawurlencode", explode ( "/", $path ) ) );
		$tempFilePath = null;
		$fullThumbnailPath = null;
		$thumbnailPath = null;
		$markup = null;
		
		try {
			// Get and validate input data
			$path = $thumbnailInfo ['path'];
			$width = $thumbnailInfo ['width'];
			$height = $thumbnailInfo ['height'];
			$lastModified = $thumbnailInfo ['lastModified'];
			
			if (! is_numeric ( $width ) || ! is_numeric ( $height ) || ! is_numeric ( $lastModified )) {
				throw new ApplicationException ( 'Invalid input data' );
			}
			
			if (! $thumbnailParams) {
				$thumbnailParams = $this->getThumbnailParams ();
				$thumbnailParams ['width'] = $width;
				$thumbnailParams ['height'] = $height;
			}
			
			$thumbnailPath = $this->getThumbnailImagePath ( $thumbnailParams, $path, $lastModified );
			// logger($thumbnailPath);
			
			$fullThumbnailPath = temp_path ( ltrim ( $thumbnailPath, '/' ) );
			// logger(temp_path());
			// $encoded = implode ( "/", array_map ( "rawurlencode", explode ( "/", $path ) ) );
			// Save the file locally
			$tempFilePath = $this->getLocalTempFilePath ( $path );
			
			if (! $fullThumbnailPath = $this->downloadFile ( $path, $thumbnailPath )) {
				throw new SystemException ( 'Error saving remote file to a temporary location' );
			}
			logger ( $fullThumbnailPath );
			// Resize the thumbnail and save to the thumbnails directory
			$this->resizeImage ( $fullThumbnailPath, $thumbnailParams, $tempFilePath );
		} catch ( Exception $ex ) {
			// $this->err ( $ex->getMessage () );
			return [ 
					'isError' => true 
			];
		}
		logger ( $publicUrl . $tempFilePath );
		return [ 
				'isError' => false,
				'imageUrl' => $publicUrl .FtpLibraryItem::getInstance ()->getbasename ( $tempFilePath )  
		];
	}
	protected function resizeImage($fullThumbnailPath, $thumbnailParams, $tempFilePath) {
		/**
		 * PHP must be enabled:
		 * extension=php_mbstring.dll
		 * extension=php_exif.dll
		 *
		 * @var unknown
		 */
		$image = new ImageResize ( $fullThumbnailPath );
		$image->resizeToWidth ( $thumbnailParams ['width'] );
// 		$image->resizeToHeight ( $thumbnailParams ['height'] );
		logger ( $tempFilePath );
		$image->save ( $tempFilePath );
	}
	protected function getThumbnailImagePath($thumbnailParams, $itemPath, $lastModified) {
		logger ( $itemPath );
		logger ( $lastModified );
		$itemSignature = md5 ( $itemPath ) . $lastModified;
		
		$thumbFile = 'thumb_' . $itemSignature . '_' . $thumbnailParams ['width'] . 'x' . $thumbnailParams ['height'] . '_' . $thumbnailParams ['mode'] . '.' . $thumbnailParams ['ext'];
		
		$partition = implode ( '/', array_slice ( str_split ( $itemSignature, 3 ), 0, 3 ) ) . '/';
		
		$result = $this->getThumbnailDirectory () . $partition . $thumbFile;
		
		return $result;
	}
	protected function getThumbnailDirectory() {
	}
	protected function getLocalTempFilePath($fileName) {
		$fileName = md5 ( $fileName . uniqid () . microtime () );
		
		// $path = temp_path () . '/media';
		$path = __DIR__ . '/../../public/_thumbnail';
		
		if (! is_dir ( $path ))
			mkdir ( $path, 0777 );
		
		return $path . '/' . $fileName;
	}
	function getThumbnailParams($viewMode = null) {
		$result = [ 
				'mode' => 'crop',
				'ext' => 'png' 
		];
		
		if ($viewMode) {
			if ($viewMode == self::VIEW_MODE_LIST) {
				$result ['width'] = 75;
				$result ['height'] = 75;
			} else {
				$result ['width'] = 165;
				$result ['height'] = 165;
			}
		}
		
		return $result;
	}
}
