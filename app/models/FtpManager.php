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
	protected function setCurrentFolder($path) {
		$path = FtpLibrary::validatePath ( $path );
		
		$this->putSession ( 'current_folder', $path );
	}
	protected function getCurrentFolder() {
		$folder = $this->getSession ( 'current_folder', self::FOLDER_ROOT );
		
		return $folder;
	}
	protected function listFolderItems($folder, $filter, $sortBy) {
		$filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
		
		return $this->listFolderContents ( $folder, $sortBy, $filter );
	}
}
