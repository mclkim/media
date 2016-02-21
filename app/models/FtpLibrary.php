<?php

namespace App\Models;

class FtpLibrary {
	const SORT_BY_TITLE = 'title';
	const SORT_BY_SIZE = 'size';
	const SORT_BY_MODIFIED = 'modified';
	protected $ftp = null;
	function __construct($ftp) {
		$this->ftp = $ftp;
	}
	private function parseScanLine($rawlistline) {
		$listline ['raw'] = $rawlistline;
		// -------------------------------------------------------------------------
		// Scanning:
		// 1. first scan with strict rules
		// 2. if that does not match, scan with less strict rules
		// 3. if that does not match, scan with rules for specific FTP servers (AS400)
		// 4. and if that does not match, return the raw line
		// -------------------------------------------------------------------------
		
		// ----------------------------------------------
		// 1. Strict rules
		// ----------------------------------------------
		if (preg_match ( "/([-dl])([rwxsStT-]{9})[ ]+([0-9]+)[ ]+([^ ]+)[ ]+(.+)[ ]+([0-9]+)[ ]+([a-zA-Z]+[ ]+[0-9]+)[ ]+([0-9:]+)[ ]+(.*)/", $rawlistline, $regs ) == true) {
			// permissions number owner group size month day year/hour filename
			$listline ["scanrule"] = "rule-1";
			$listline ["dirorfile"] = "$regs[1]"; // Directory ==> d, File ==> -
			$listline ["dirfilename"] = "$regs[9]"; // Filename
			$listline ["files_inside"] = "$regs[3]";
			$listline ["size"] = "$regs[6]"; // Size
			$listline ["owner"] = "$regs[4]"; // Owner
			$listline ["group"] = trim ( $regs [5] ); // Group
			$listline ["permissions"] = "$regs[2]"; // Permissions
			$listline ["mtime"] = "$regs[7] $regs[8]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
		}		

		// ----------------------------------------------
		// 2. Less strict rules
		// ----------------------------------------------
		elseif (preg_match ( "/([-dl])([rwxsStT-]{9})[ ]+(.*)[ ]+([a-zA-Z0-9 ]+)[ ]+([0-9:]+)[ ]+(.*)/", $rawlistline, $regs ) == true) {
			// permissions number/owner/group/size
			// month-day year/hour filename
			$listline ["scanrule"] = "rule-2";
			$listline ["dirorfile"] = "$regs[1]"; // Directory ==> d, File ==> -
			$listline ["dirfilename"] = "$regs[6]"; // Filename
			$listline ["size"] = "$regs[3]"; // Number/Owner/Group/Size
			$listline ["permissions"] = "$regs[2]"; // Permissions
			$listline ["mtime"] = "$regs[4] $regs[5]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
		}		

		// ----------------------------------------------
		// 3. Specific FTP server rules
		// ----------------------------------------------
		
		// ---------------
		// 3.1 Windows
		// ---------------
		elseif (preg_match ( "/([0-9\\/-]+)[ ]+([0-9:AMP]+)[ ]+([0-9]*|<DIR>)[ ]+(.*)/", $rawlistline, $regs ) == true) {
			// date time size filename
			
			$listline ["scanrule"] = "rule-3.1";
			if ($regs [3] == "<DIR>") {
				$listline ["size"] = "";
			} else {
				$listline ["size"] = "$regs[3]";
			} // Size
			$listline ["dirfilename"] = "$regs[4]"; // Filename
			$listline ["owner"] = ""; // Owner
			$listline ["group"] = ""; // Group
			$listline ["permissions"] = ""; // Permissions
			$listline ["mtime"] = "$regs[1] $regs[2]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
			
			if ($listline ["size"] != "") {
				$listline ["dirorfile"] = "-";
			} else {
				$listline ["dirorfile"] = "d";
			}
		}		

		// ---------------
		// 3.2 Netware
		// Thanks to Danny!
		// ---------------
		elseif (preg_match ( "/([-]|[d])[ ]+(.{10})[ ]+([^ ]+)[ ]+([0-9]*)[ ]+([a-zA-Z]*[ ]+[0-9]*)[ ]+([0-9:]*)[ ]+(.*)/", $rawlistline, $regs ) == true) {
			// dir/file perms owner size month day hour filename
			$listline ["scanrule"] = "rule-3.2";
			$listline ["dirorfile"] = "$regs[1]"; // Directory ==> d, File ==> -
			$listline ["dirfilename"] = "$regs[7]"; // Filename
			$listline ["size"] = "$regs[4]"; // Size
			$listline ["owner"] = "$regs[3]"; // Owner
			$listline ["group"] = ""; // Group
			$listline ["permissions"] = "$regs[2]"; // Permissions
			$listline ["mtime"] = "$regs[5] $regs[6]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
		}		

		// ---------------
		// 3.3 AS400
		// ---------------
		elseif (preg_match ( "/([a-zA-Z0-9_-]+)[ ]+([0-9]+)[ ]+([0-9\\/-]+)[ ]+([0-9:]+)[ ]+([a-zA-Z0-9_ -\*]+)[ \\/]+([^\\/]+)/", $rawlistline, $regs ) == true) {
			// owner size date time type filename
			
			if ($regs [5] != "*STMF") {
				$directory_or_file = "d";
			} elseif ($regs [5] == "*STMF") {
				$directory_or_file = "-";
			}
			
			$listline ["scanrule"] = "rule-3.3";
			$listline ["dirorfile"] = "$directory_or_file"; // Directory ==> d, File ==> -
			$listline ["dirfilename"] = "$regs[6]"; // Filename
			$listline ["size"] = "$regs[2]"; // Size
			$listline ["owner"] = "$regs[1]"; // Owner
			$listline ["group"] = ""; // Group
			$listline ["permissions"] = ""; // Permissions
			$listline ["mtime"] = "$regs[3] $regs[4]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
		}		

		// ---------------
		// 3.4 Titan
		// Owner, group are modified compared to rule 1
		// TODO: integrate this rule in rule 1 itself
		// ---------------
		elseif (preg_match ( "/([-dl])([rwxsStT-]{9})[ ]+([0-9]+)[ ]+([a-zA-Z0-9]+)[ ]+([a-zA-Z0-9]+)[ ]+([0-9]+)[ ]+([a-zA-Z]+[ ]+[0-9]+)[ ]+([0-9:]+)[ ](.*)/", $rawlistline, $regs ) == true) {
			// dir/file permissions number owner group size month date time file
			$listline ["scanrule"] = "rule-3.4";
			$listline ["dirorfile"] = "$regs[1]"; // Directory ==> d, File ==> -
			$listline ["dirfilename"] = "$regs[9]"; // Filename
			$listline ["size"] = "$regs[6]"; // Size
			$listline ["owner"] = "$regs[4]"; // Owner
			$listline ["group"] = "$regs[5]"; // Group
			$listline ["permissions"] = "$regs[2]"; // Permissions
			$listline ["mtime"] = "$regs[7] $regs[8]"; // Mtime -- format depends on what FTP server returns (year, month, day, hour, minutes... see above)
		} 		

		// ----------------------------------------------
		// 4. If nothing matchs, return the raw line
		// ----------------------------------------------
		else {
			$listline ["scanrule"] = "rule-4";
			$listline ["dirorfile"] = "u";
			$listline ["dirfilename"] = $rawlistline;
		}
		
		// -------------------------------------------------------------------------
		// Remove the . and .. entries
		// Remove the total line that some servers return
		// -------------------------------------------------------------------------
		if ($listline ["dirfilename"] == "." || $listline ["dirfilename"] == "..") {
			return "";
		} elseif (substr ( $rawlistline, 0, 5 ) == "total") {
			return "";
		}
		
		// -------------------------------------------------------------------------
		// And finally... return the nice list!
		// -------------------------------------------------------------------------
		return $listline;
	}
	protected function parseRawList($directory = null, $recursive = false) {
		try {
			// $list = $this->ftp->rawlist ( $directory );
			$options = $recursive ? '-alnR' : '-aln';
			$options = '-rtla';
			$list = $this->ftp->rawlist ( $options . ' ' . $directory );
		} catch ( Exception $e ) {
			throw new FtpException ( $e->getMessage () );
			return false;
		}
		
		if (! is_array ( $list )) {
			return array (
					'folders' => array (),
					'files' => array () 
			);
		}
		
		// include ANIME_PATH . DS . 'include/include.js.php';
		$folders_list = array ();
		$files_list = array ();
		
		foreach ( $list as $line ) {
			$listline = $this->parseScanLine ( $line );
			
			if ($listline == "") {
				continue;
			}
			
			$isdir = ($listline ['dirorfile'] === 'd');
			$now = now();
			$stamp = strtotime ( $listline ['mtime'] );
			$ext = pathinfo ( $listline ['dirfilename'], PATHINFO_EXTENSION ) ?  : 'unknown';
			
			$item = ($isdir) ? 'folder' : 'file';
			
			$name = $listline ['dirfilename'];
			$endung = strtolower ( substr ( strrchr ( $name, "." ), 1 ) );
			$path = "$directory/$name";
			logger ( $endung );
			$type = FtpLibraryItem::getInstance ()->getFileType ( $item, $ext );
			$icon = FtpLibraryItem::getInstance ()->itemTypeToIconClass ( $item, $type );
			
			if ($listline ["dirorfile"] == "d") {
				$folders_list [] = array (
						'item' => $item,
						'icon' => $icon,
						'type' => $type,
						'rights' => $listline ['permissions'],
						'files_inside' => $listline ['files_inside'],
						'owner' => $listline ['owner'],
						'group' => $listline ['group'],
						'size' => $listline ['size'],
						'date' => $listline ['mtime'],
						'title' => $listline ['dirfilename'],
						'path' => $path,
						'modified' => $stamp,
						'raw' => $listline ['raw'] 
				);
			} else {
				$files_list [] = array (
						'item' => $item,
						'icon' => $icon,
						'type' => $type,
						'rights' => $listline ['permissions'],
						'owner' => $listline ['owner'],
						'group' => $listline ['group'],
						'size' => $listline ['size'],
						'date' => $listline ['mtime'],
						'title' => $listline ['dirfilename'],
						'path' => $path,
						'modified' => $stamp,
						'ext' => $ext,
						'base64' => base64_encode ( $listline ['dirfilename'] ),
						'raw' => $listline ['raw'] 
				);
			}
		}
		
		return array (
				'folders' => (is_array ( $folders_list )) ? $folders_list : array (),
				'files' => (is_array ( $files_list )) ? $files_list : array () 
		);
	}
	/**
	 * Returns a list of folders and files in a Library folder.
	 *
	 * @param string $folder
	 *        	Specifies the folder path relative the the Library root.
	 * @param string $sortBy
	 *        	Determines the sorting preference.
	 *        	Supported values are 'title', 'size', 'lastModified' (see SORT_BY_XXX class constants) and FALSE.
	 * @param string $filter
	 *        	Determines the document type filtering preference.
	 *        	Supported values are 'image', 'video', 'audio', 'document' (see FILE_TYPE_XXX constants of MediaLibraryItem class).
	 * @return array Returns an array of MediaLibraryItem objects.
	 */
	public function listFolderContents($folder = '/', $sortBy = 'title', $filter = null) {
		$fullFolderPath = self::validatePath ( $folder );
		
		$folderContents = $this->parseRawList ( $fullFolderPath );
		
		/**
		 * Sort the result and combine the file and folder lists
		 */
		
		if ($sortBy !== false) {
			$this->sortItemList ( $folderContents ['files'], $sortBy );
			$this->sortItemList ( $folderContents ['folders'], $sortBy );
		}
		
		$this->filterItemList ( $folderContents ['files'], $filter );
		
		$folderContents = array_merge ( $folderContents ['folders'], $folderContents ['files'] );
		
		return $folderContents;
	}
	public static function validatePath($path, $normalizeOnly = false) {
		$path = str_replace ( '\\', '/', $path );
		$path = '/' . trim ( $path, '/' );
		
		if ($normalizeOnly)
			return $path;
		
		if (strpos ( $path, '..' ) !== false)
			throw new ApplicationException ( "지정된 잘못된 파일 경로: '$path'." );
		
		if (strpos ( $path, './' ) !== false || strpos ( $path, '//' ) !== false)
			throw new ApplicationException ( "지정된 잘못된 파일 경로: '$path'." );
		
		return $path;
	}
	protected function sortItemList(&$itemList, $sortBy) {
		$files = [ ];
		$folders = [ ];
		
		usort ( $itemList, function ($a, $b) use($sortBy) {
			switch ($sortBy) {
				case self::SORT_BY_TITLE :
					return strcasecmp ( $a->title, $b->title );
				case self::SORT_BY_SIZE :
					if ($a->size > $b->size)
						return - 1;
					
					return $a->size < $b->size ? 1 : 0;
					break;
				case self::SORT_BY_MODIFIED :
					if ($a->lastModified > $b->lastModified)
						return - 1;
					
					return $a->lastModified < $b->lastModified ? 1 : 0;
					break;
			}
		} );
	}
	protected function filterItemList(&$itemList, $filter) {
		if (! $filter)
			return;
		
		$result = [ ];
		foreach ( $itemList as $item ) {
			if ($item->getFileType () == $filter)
				$result [] = $item;
		}
		
		$itemList = $result;
	}
}
