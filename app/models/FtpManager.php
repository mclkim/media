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
	// public function listFolderItems($folder, $filter, $sortBy) {
	// $filter = $filter !== self::FILTER_EVERYTHING ? $filter : null;
	
	// return $this->listFolderContents ( $folder, $sortBy, $filter );
	// }
 //    public function splitPathToSegments($path)
 //    {
 //        $path = FtpLibrary::validatePath($path, true);
 //        $path = explode('/', ltrim($path, '/'));

 //        $result = [];
 //        while (count($path) > 0) {
 //            $folder = array_pop($path);

 //            $result[$folder] = implode('/', $path).'/'.$folder;
 //            if (substr($result[$folder], 0, 1) != '/')
 //                $result[$folder] = '/'.$result[$folder];
 //        }

 //        return array_reverse($result);
 //    }
}
