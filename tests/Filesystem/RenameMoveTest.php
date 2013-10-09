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
        $targetpath = getcwd() . '/tests/Assets/newname.txt';
        $target = new File($targetpath);

        $source = $this->system->rename($source, $target);
        $this->assertSame($targetpath, $source->getPathname());
        unlink($target->getPathname());
    }

}
