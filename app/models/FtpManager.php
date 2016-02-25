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
	public function setCurrentFolder($folder) {
		$folder = FtpLibrary::validatePath ( $folder );
		// logger ( 'setCurrentFolder' );
		// logger ( $folder );
		
		$_SESSION ['current_folder'] = $folder;
	}
	public function getCurrentFolder() {
		// $folder = $this->getSession ( 'current_folder', self::FOLDER_ROOT );
		$folder = if_exists ( $_SESSION, 'current_folder', '/' );
		// logger ( 'getCurrentFolder' );
		// logger ( $folder );
		
		return $folder;
	}
	public function listFolderItems($folder, $filter, $sortBy) {
		$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
		
		return $this->listFolderContents ( $folder, $sortBy, $filter );
	}
	public function breadcrumb($path) {
		$path = FtpLibrary::validatePath($path, true);
		// $breadcrumb = explode ( "/", rtrim ( $path, '/' ) );
		$path = explode('/', ltrim($path, '/'));

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
}
