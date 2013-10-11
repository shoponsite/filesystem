<?php

namespace Shoponsite\Filesystem;

use Shoponsite\Filesystem\Exceptions\FileExistsException;

class Filesystem implements FilesystemInterface{

    /**
     * @param File $source
     * @param File $target
     * @param bool $override
     * @return bool
     */
    public function copy(File $file, File $target, $override = false)
    {
        if(!$override && ($target->isFile() || $target->isDir()))
        {
            throw new FileExistsException('File allready exists and we are not allowed to override');
        }

        $this->validateTargetDir($target);

        copy($file->getPathname(), $target->getPathname());
    }

    /**
     * @param File $source
     * @param string $name
     * @return bool
     */
    public function rename(File $source, $name)
    {
        rename($source->getPathname(), $source->getPath() . DIRECTORY_SEPARATOR . $name);

        return new File($source->getPath() . DIRECTORY_SEPARATOR . $name);
    }

    /**
     * @param File $source
     * @param string $dir
     * @return File
     */
    public function move(File $source, $dir)
    {
        rename($source->getPathname(), $dir . DIRECTORY_SEPARATOR . $source->getFilename());

        return new File($dir . DIRECTORY_SEPARATOR . $source->getFilename());
    }


    /**
     * Umask is not safe considering multithreaded servers... but this is alot easier and takes less computing time
     * than always checking for a recursive chmod on a certain folder.
     *
     * if $mode does not have enough rights for the apache user to create a file in the newly created dir
     * this means that you wont be able to create subdirs either.
     * so
     *
     * @example $this->mkdir('dir', 0111) will work but you won't be able to create files!
     * @example $this->mkdir('sub/dir', 0111) won't work: no rights to create folder in 'sub' folder
     *
     * @param File $target
     * @param int $mode
     * @return File
     */
    public function mkdir(File $target, $mode = 0777)
    {
        if($target->isDir())
        {
            return $target;
        }

        $old = umask(0);

        mkdir($target->getPathname(), $mode, true);

        umask($old);

        return new File($target->getPathname());
    }

    /**
     * @param string|array|\Traversable $files
     * @param bool $recursive
     * @return bool
     */
    public function remove($files, $recursive = false)
    {
        if(!is_array($files))
        {
            $files = array($files);
        }

        foreach($files as $file)
        {
            if(is_string($file))
            {
                $file = new File($file);
            }

            if($this->exists($file))
            {
                $this->delete($file, $recursive);
            }
        }
    }

    /**
     * @param File $file
     * @return bool
     */
    public function exists(File $file)
    {
        return $file->isFile() || $file->isDir();
    }


    /**
     * Chmod a folder or file. If a folder is provided you can do this recursively
     *
     * @param File $target
     * @param int $mode
     * @param bool $recursive
     * @return File
     */
    public function chmod(File $target, $mode = 0777, $recursive = false)
    {

        if(in_array($target->getFilename(), array('.', '..', '.DS_Store')))
        {
            return $target;
        }

        if($target->isFile() || !$recursive)
        {
            chmod($target->getPathname(), $mode);
        }

        else
        {
            chmod($target->getPathname(), $mode);

            foreach($target->getSubfiles() as $file)
            {
                $this->chmod($file, $mode, true);
            }
        }

        return $target;
    }


    protected function validateTargetDir(File $target)
    {
        $dir = $target->getPath();

        if(is_dir($dir))
            return true;

        return $this->mkdir($dir);
    }

    /**
     * @param File $file
     * @param bool $recursive
     */
    protected function delete(File $file, $recursive)
    {
        if($file->isDir())
        {
            $files = $file->getSubfiles();

            if(count($files))
            {
                $this->remove($files, $recursive);
            }

            rmdir($file->getPathname());
        }
        else
        {
            unlink($file->getPathname());
        }

    }

}