<?php

use Shoponsite\Filesystem\File;

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

}
