<?php

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

class FileTest extends PHPUnit_Framework_TestCase {

    public function testReadablePermissions()
    {
        $target = new File(getcwd() . '/tests/permissions.txt');
        touch($target->getPathname());
        chmod($target->getPathname(), 0755);
        $this->assertSame(755, $target->getReadablePermissions());
        unlink($target->getPathname());
    }

    public function testGettingSubfiles()
    {
        $target = new File(getcwd() . '/tests');
        $files = $target->getSubfiles();
        $this->assertCount(4, $files);
    }

    public function testGetParent()
    {
        $target = getcwd() . '/tests/Assets';
        $target = new File($target);
        $this->assertEquals(getcwd() . '/tests', $target->getParent()->getPathname());
    }

    public function testMove()
    {
        $filepath = getcwd() . '/tests/Assets/filetomove.txt';
        $targetdir = getcwd() . '/tests/Assets/tmpmover';
        touch($filepath);
        mkdir($targetdir);
        $file = new File($filepath);
        $targetdir = $targetdir;
        $file = $file->move(new Filesystem, $targetdir);

        $this->assertSame($targetdir, $file->getPath());

        unlink($file->getPathname());
        rmdir($targetdir);
    }

    public function testMovingIntoNonExistingDir()
    {
        $filepath = getcwd() . '/tests/Assets/filetomove.txt';
        $targetdir = getcwd() . '/tests/Assets/tmpmover';
        touch($filepath);

        $file = new File($filepath);
        $targetdir = $targetdir;
        $file = $file->move(new Filesystem, $targetdir);

        $this->assertSame($targetdir, $file->getPath());

        unlink($file->getPathname());
        rmdir($targetdir);
    }

}
