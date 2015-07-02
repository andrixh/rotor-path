<?php
/**
 * Created by IntelliJ IDEA.
 * User: andri
 * Date: 7/1/15
 * Time: 6:54 PM
 */

namespace Rotor\Test;
use Rotor\Path;

class PathTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function creates_a_Path_object_via_static_call(){
		$path = Path::Create('');
		$this->assertInstanceOf('Rotor\Path',$path);
	}

	/**
	 * @test
	 */
	public function creates_a_Path_object_via_constructor(){
		$path = new Path('');
		$this->assertInstanceOf('Rotor\Path',$path);
	}

	///**
	// * @test
	// */
	//public function detects_a_trailing_slash_as_a_directory(){
	//
	//}

	/**
	 * test
	 */
	public function compacts_a_path_with_multiple_consecutive_slashes(){
		$path = new Path('/path//to/somewhere/');
		$this->assertEquals('/path/to/somewhere/',$path->__toString());

		$path = new Path('/path//to////somewhere/');
		$this->assertEquals('/path/to/somewhere/',$path->__toString());

		$path = new Path('///');
		$this->assertEquals('/',$path->__toString());
	}

	/**
	 * @test
	 */
	public function functions_as_realpath_but_with_non_existing_paths(){
		$path = new path('/var/../test/');
		$this->assertEquals('/test/',$path->__toString());

		$path = new path('/var/./test/');
		$this->assertEquals('/var/test/',$path->__toString());

		$path = new path('/var/./test/.././././../');
		$this->assertEquals('/',$path->__toString());
	}








}
