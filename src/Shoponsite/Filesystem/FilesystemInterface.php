<?php

namespace Shoponsite\Filesystem;


interface FilesystemInterface {

    /**
     * @param File $source
     * @param File $target
     * @param bool $override
     * @return bool
     */
    public function copy(File $source, File $target, $override = false);

    /**
     * @param File $source
     * @param File $target
     * @return bool
     */
    public function rename(File $source,File $target);

    /**
     * @param File $target
     * @param int $mode
     * @return File
     */
    public function mkdir(File $target, $mode = 0777);

    /**
     * @param string|array|\Traversable $files
     * @return bool
     */
    public function remove($files);

    /**
     * Chmod a folder or file. If a folder is provided you can do this recursively
     *
     * @param File $target
     * @param int $mode
     * @param bool $recursive
     * @return File
     */
    public function chmod(File $target, $mode = 0777, $recursive = false);
}