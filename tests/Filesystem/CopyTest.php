<?php

use Shoponsite\Filesystem\File;
use Shoponsite\Filesystem\Filesystem;

class CopyTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Filesystem
     */
    protected $system;

    /**
     * @var File
     */
    protected $source;

    public function setUp()
    {
        $this->system = new Filesystem();
        $this->source = new File(getcwd() . '/tests/Assets/sample.txt');
    }

    public function tearDown()
    {
        unset($this->system);
        if(is_file(getcwd() . '/tests/Assets/copied.txt'))
            unlink(getcwd() . '/tests/Assets/copied.txt');
    }

    public function testValidCopy()
    {

        $target = new File(getcwd() . '/tests/Assets/copied.txt');

        $this->system->copy($this->source,$target);
        $this->assertTrue($target->isFile());
        unlink($target->getPathname());
    }

    /**
     * @expectedException Shoponsite\Filesystem\Exceptions\FileExistsException
     */
    public function testValidCopyWithoutOverride()
    {
        $target = new File(getcwd() . '/tests/Assets/copied.txt');

        $this->system->copy($this->source, $target);
        $this->system->copy($this->source, $target, false);
    }

    public function testValidCopyWithOverride()
    {
        $target = new File(getcwd() . '/tests/Assets/copied.txt');
        touch(getcwd() . '/tests/Assets/copied.txt');
        $this->system->copy($this->source, $target, true);
        $this->assertSame(file_get_contents($this->source->getPathname()), file_get_contents($target->getPathname()));
    }

    public function testCopyTargetDirDoesNotExist()
    {
//        $target = new File(getcwd() .'/tests/Assets/storage/copied.txt');
//        $this->system->copy($this->source, $target);
    }


}
