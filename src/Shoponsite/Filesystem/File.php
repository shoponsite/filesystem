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


}