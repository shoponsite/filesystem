<?php

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

class MakeDirTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Filesystem
     */
    protected $system;

    public function setUp()
    {
        $this->system = new Filesystem();
    }

    public function tearDown()
    {
        unset($this->system);
        if(is_dir(getcwd() . '/tests/Assets/storage'))
            rmdir(getcwd() . '/tests/Assets/storage');
    }

    public function testCreatingDirThatAllreadyExists()
    {
        $target = new File(getcwd() . '/tests/Assets/tmp');
        $this->system->mkdir($target);
        $this->system->mkdir($target);
        rmdir($target->getPathname());
    }

    public function testCreatingDirInExistingFolder()
    {
        $target = getcwd() . '/tests/Assets/storage/tmp';
        $target = new File($target);
        $this->system->mkdir($target);
        $this->assertTrue(is_dir($target->getPathname()));
        rmdir($target->getPathname());
    }

    public function testCreatingDirInNonExistingFolder()
    {
        $target = getcwd() . '/tests/Assets/storage/super/sub/directory';
        $target = new File($target);
        $this->system->mkdir($target);
        $this->assertTrue(is_dir($target->getPathname()));
        rmdir(getcwd() . '/tests/Assets/storage/super/sub/directory');
        rmdir(getcwd() . '/tests/Assets/storage/super/sub');
        rmdir(getcwd() . '/tests/Assets/storage/super/');
    }

    public function testDefaultPermissionsForNewDir()
    {
        $target = getcwd() . '/tests/Assets/storage/newdirectory';
        $target = new File($target);
        $target = $this->system->mkdir($target);
        $this->assertSame(777 , $this->convertFilePerms($target));
        $this->assertTrue($target->isDir());
        rmdir($target->getPathname());
    }

    public function testOtherPermissionsForNewDir()
    {
        $target = getcwd() . '/tests/Assets/storage/';
        $target = new File($target);
        $target = $this->system->mkdir($target, 0111);
        $this->assertSame(111, $this->convertFilePerms($target));
        $this->assertTrue($target->isDir());
        rmdir($target->getPathname());
    }

    public function testOtherPermissionsForNewSubdir()
    {
        $target = getcwd() . '/tests/Assets/storage/some/sub/directory';
        $target = new File($target);
        $target = $this->system->mkdir($target, 0711);
        $this->assertTrue($target->isDir());
        rmdir(getcwd() . '/tests/Assets/storage/some/sub/directory');
        rmdir(getcwd() . '/tests/Assets/storage/some/sub/');
        rmdir(getcwd() . '/tests/Assets/storage/some/');
    }

    protected function convertFilePerms($file)
    {
        return (int) substr(sprintf('%o', $file->getPerms()), -4);
    }

}
