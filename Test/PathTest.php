<?php
/**
 * Created by IntelliJ IDEA.
 * User: andri
 * Date: 7/1/15
 * Time: 6:54 PM
 */

namespace Rotor\Test;

use Rotor\Path;

class PathTest extends \PHPUnit_Framework_TestCase
{

    public function test_creates_a_Path_object_via_static_call()
    {
        $path = Path::Create('');
        $this->assertInstanceOf('Rotor\Path', $path);
    }

    public function test_creates_a_Path_object_via_constructor()
    {
        $path = new Path('');
        $this->assertInstanceOf('Rotor\Path', $path);
    }

    public function test_detects_a_trailing_slash_as_a_directory(){
        $path = new Path('/');
        $this->assertTrue($path->isDirectory());

        $path = new Path('/var/test/');
        $this->assertTrue($path->isDirectory());

        $path = new Path('notAblsolute/test/');
        $this->assertTrue($path->isDirectory());
    }

    public function test_interprets_lack_of_trailing_slash_as_not_a_directory()
    {
        $path = new Path('/var/test');
        $this->assertFalse($path->isDirectory());
    }

    public function test_interprets_as_directory_when_provided_is_directory_flag(){
        $path = new Path('/var/test',true);
        $this->assertTrue($path->isDirectory());

        $path = new Path('/var/test/',true);
        $this->assertTrue($path->isDirectory());
    }

    public function test_compacts_a_path_with_multiple_consecutive_slashes()
    {
        $path = new Path('/path//to/somewhere/');
        $this->assertEquals('/path/to/somewhere/', $path->__toString());

        $path = new Path('/path//to////somewhere/');
        $this->assertEquals('/path/to/somewhere/', $path->__toString());

        $path = new Path('///');
        $this->assertEquals('/', $path->__toString());
    }

    public function test_functions_as_realpath_but_with_non_existing_paths()
    {
        $path = new path('/var/../test/');
        $this->assertEquals('/test/', $path->__toString());

        $path = new path('/var/./test/');
        $this->assertEquals('/var/test/', $path->__toString());

        $path = new path('/var/./test/.././././../');
        $this->assertEquals('/', $path->__toString());
    }

    public function test_interprets_no_ending_slash_as_file(){
        $path = new path('/var/test/file.ext');
        $this->assertTrue($path->isFile());

        $path = new Path('/var/something');
        $this->assertTrue($path->isFile());

        $path = new Path('filename');
        $this->assertTrue($path->isFile());

        $path = new Path('filename.ext');
        $this->assertTrue($path->isFile());

        $path = new Path('/filename.ext');
        $this->assertTrue($path->isFile());

        $path = new Path('path/to/file');
        $this->assertTrue($path->isFile());
    }

    public function test_provides_filename_for_valid_file_paths(){
        $path = new Path('path/to/file');
        $this->assertFalse($path->isDirectory());
        $this->assertTrue($path->isFile());
        //$this->assertEquals('file',$path->filename());

    }

}
