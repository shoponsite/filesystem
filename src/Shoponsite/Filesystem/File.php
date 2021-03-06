<?php

namespace Shoponsite\Filesystem;


class File extends \SplFileInfo implements FileInterface{

    /**
     * @return int
     */
    public function getReadablePermissions()
    {
        return (int) substr(sprintf('%o', $this->getPerms()), -3);
    }

    /**
     * Has been implemented because the server did not have this native function.
     *
     * It can be removed when the server gets an upgrade.
     *
     * @return mixed|string
     */
    public function getExtension()
    {
        return pathinfo($this->getPathname(), PATHINFO_EXTENSION);
    }

    /**
     * @return array[File]
     */
    public function getSubfiles()
    {
        $files = scandir($this->getPathname());

        $files = array_filter($files, function($item)
        {
            return !in_array($item, array('.', '..', '.DS_Store'));
        });

        $path = $path = $this->getPathname();

        array_walk($files, function(&$item) use ($path)
        {
            $item = new File($path . '/' . $item);
        });

        return $files;
    }

    /**
     * @return File
     */
    public function getParent()
    {
        return new File($this->getPath());
    }

    /**
     * @inheritdoc
     */
    public function move(Filesystem $system, $path)
    {
        $dir = new self($path);

        if(!$dir->isDir())
        {
            $system->mkdir($dir);
        }

        $system->move($this, $dir->getPathname());

        return new File($dir->getPathname() . DIRECTORY_SEPARATOR . $this->getFilename());
    }


}