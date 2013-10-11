<?php

use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Filesystem\File;

class ExistsTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \Shoponsite\Filesystem\Filesystem
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

    public function testExists()
    {
        $this->assertTrue($this->filesystem->exists(new File(getcwd() . '/tests/Assets/sample.txt')));

        $this->assertFalse($this->filesystem->exists(new File(getcwd() . '/tests/Assets/nonexisting.txt')));

        $this->assertTrue($this->filesystem->exists(new File(getcwd() . '/tests/Assets')));
    }

}
