<?php
use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Filesystem\File;

class RenameMoveTest extends PHPUnit_Framework_TestCase {

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
    }

    public function testRename()
    {
        $source = getcwd() . '/tests/Assets/tmpname.txt';
        touch($source);
        $source = new File($source);

        $source = $this->system->rename($source, 'newname.txt');
        $this->assertSame('newname.txt', $source->getFilename());
        unlink($source->getPathname());
    }

    public function testMove()
    {
        $source = getcwd() . '/tests/Assets/tmpname.txt';
        touch($source);
        $sourcefile = new File($source);
        $targetdir = getcwd() . '/tests/Assets/movedfiledir';
        mkdir($targetdir);

        $file = $this->system->move($sourcefile, $targetdir);
        $this->assertSame($targetdir, $file->getPath());

        unlink($file->getPathname());
        rmdir($targetdir);

    }

}
