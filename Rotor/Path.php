<?php
namespace Rotor;

class Path {

	protected $pathStr = '';
	protected $is_dir = false;

	protected static $dirCache = [];

	/**
	 * @param string $pathStr
	 * @return Path
	 */
	public static function Create($pathStr) {
		return new Path($pathStr);
	}

	/**
	 * @param string $pathStr
	 */
	public function __construct($pathStr) {
		$this->pathStr = $this->compactPath($pathStr);
		$this->is_dir = $this->detectDirectoryStatus();
	}

	protected function compactPath($pathStr){
		$hasLeadingSlash = substr($pathStr,0,1) == '/';
		$hasTrailingSlash = mb_substr($pathStr,-1) == '/';
		$parts = explode('/',$pathStr);

		$resultParts = [];
		for ($i = 0; $i < count($parts); $i++) {
			if ($parts[$i] != '' && $parts[$i] != '.'){
				if ($parts[$i] == '..'){
					if (count($resultParts)>0){
						array_pop($resultParts);
					}
				} else {
					$resultParts[] = $parts[$i];
				}
			}
		}

		$result = implode('/',$resultParts);
		if ($hasLeadingSlash) {
			$result = '/'.$result;
		}
		if ($hasTrailingSlash and $result != '/') {
			$result.='/';
		}
		return $result;
	}

	protected function detectDirectoryStatus(){
		if (mb_substr($this->pathStr,-1) == '/') {

		}
	}

	public function isDirectory() {
		return $this->is_dir;
	}

	/**
	 * @return string
	 */
	public function __toString(){
		return $this->pathStr;
	}

	/**
	 * @param str $str
	 * @return Path
	 */
	public function append($str) {
		$currPath = $this->pathStr;
		if (substr($currPath,-1) == '/') {
			$currPath = substr($currPath, 0, mb_strlen($currPath) - 1);
		}
		if (substr($str,0,1) == '/') {
			$str = substr($str,1);
		}
		$resultStr = $currPath.'/'.$str;

		return new Path($resultStr);
	}

}