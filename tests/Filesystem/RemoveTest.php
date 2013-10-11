<?php

use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Filesystem\File;

class RemoveTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function setUp()
    {
        $this->filesystem = new Filesystem;
    }

    public function tearDown()
    {
        unset($this->filesystem);
    }

    public function testRemoveFile()
    {
        copy(getcwd() . '/tests/Assets/sample.txt', getcwd() . '/tests/Assets/copy.txt');
        $file = new File(getcwd() . '/tests/Assets/copy.txt');

        $this->filesystem->remove($file);

        $this->assertFalse(file_exists($file->getPathname()));
    }

    public function testRemoveDir()
    {
        mkdir(getcwd() . '/tests/Assets/removedir');

        $file = new File(getcwd() . '/tests/Assets/removedir');

        $this->filesystem->remove($file);

        $this->assertFalse(file_exists($file->getPathname()));
    }

    public function testRemoveDirRecursively()
    {
        mkdir(getcwd() . '/tests/Assets/removedir/anotherdir', 0777, true);
        copy(getcwd() . '/tests/Assets/sample.txt', getcwd() . '/tests/Assets/removedir/anotherdir/copy.txt');
        copy(getcwd() . '/tests/Assets/sample.txt', getcwd() . '/tests/Assets/removedir/anotherdir/copy2.txt');

        $file = new File(getcwd() . '/tests/Assets/removedir');

        $this->filesystem->remove($file, true);


        $this->assertFalse(file_exists(getcwd() . '/tests/Assets/removedir/anotherdir/copy.txt'));
        $this->assertFalse(file_exists(getcwd() . '/tests/Assets/removedir/anotherdir/copy2.txt'));
        $this->assertFalse(file_exists(getcwd() . '/tests/Assets/removedir/anotherdir'));
        $this->assertFalse(file_exists(getcwd() . '/tests/Assets/removedir'));
    }

}
