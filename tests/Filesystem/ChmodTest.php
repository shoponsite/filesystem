<?php

use Shoponsite\Filesystem\Filesystem;
use Shoponsite\Filesystem\File;

class ChmodTest extends PHPUnit_Framework_TestCase {

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

        $dirs = array(
            getcwd() . '/tests/Assets/tmp/sub/dir',
            getcwd() . '/tests/Assets/tmp/sub',
            getcwd() . '/tests/Assets/tmp'
        );

        foreach($dirs as $dir)
        {
            if(is_dir($dir))
                rmdir($dir);
        }
    }

    public function testSimpleChmod()
    {
        $dir = getcwd() . '/tests/Assets/tmp';
        mkdir($dir);
        $file = getcwd() . '/tests/Assets/tmp_touched.txt';
        touch($file);

        $dir = new File($dir);
        $file = new File($file);

        $this->system->chmod($dir, 0400);
        $this->system->chmod($file, 0750);

        $this->assertSame(400, $dir->getReadablePermissions());
        $this->assertSame(750, $file->getReadablePermissions());

        rmdir($dir->getPathname());
        unlink($file->getPathname());
    }

    public function testRecursiveChmod()
    {
        $target = new File(getcwd() . '/tests/Assets/tmp/sub/dir');
        $this->system->mkdir($target);

        $file = getcwd() . '/tests/Assets/tmp/sub/some_file.txt';
        touch($file);
        $file = new File($file);

        $this->system->chmod($target->getParent()->getParent(), 0751, true);
        $this->system->chmod($target->getParent()->getParent(), 0751, true);

        $message = 'failed asserting recursive chmod';

        $this->assertSame(751, $file->getReadablePermissions());
        $this->assertSame(751, $target->getReadablePermissions(), $message);
        $this->assertSame(751, $target->getParent()->getReadablePermissions(), $message);
        $this->assertSame(751, $target->getParent()->getParent()->getReadablePermissions(), $message);

        unlink($file->getPathname());
        rmdir($target->getPathname());
        rmdir($target->getParent()->getPathname());
        rmdir($target->getParent()->getParent()->getPathname());
    }

}
