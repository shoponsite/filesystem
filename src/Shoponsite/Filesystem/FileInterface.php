<?php

namespace Shoponsite\Filesystem;


interface FileInterface {

    /**
     * These are the methods from SplFileInfo Class.
     * We bind them in the interface so we make sure these methods should always exist.
     * We can't predict which ones we'll use and which not, so we bind them all just to be safe
     * @param string $fileName
     */
    public function __construct($fileName);

    /**
     * @return int
     */
    public function getATime();

    /**
     * @param string|null $suffix
     * @return string
     */
    public function getBasename($suffix = null);

    /**
     * @return int
     */
    public function getCTime();

    /**
     * @return string
     */
    public function getExtension();

    /**
     * @param string|null $className
     * @return \SplFileInfo
     */
    public function getFileInfo($className = null);

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return int
     */
    public function getGroup();

    /**
     * @return int
     */
    public function getInode();

    /**
     * @return string
     */
    public function getLinkTarget();

    /**
     * @return int
     */
    public function getMTime();

    /**
     * @return int
     */
    public function getOwner();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return \SplFileInfo
     */
    public function getPathInfo();

    /**
     * @return string
     */
    public function getPathname();

    /**
     * @return int
     */
    public function getPerms();

    /**
     * @return string
     */
    public function getRealPath();

    /**
     * @return int
     */
    public function getSize();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return bool
     */
    public function isDir();

    /**
     * @return bool
     */
    public function isExecutable();

    /**
     * @return bool
     */
    public function isFile();

    /**
     * @return bool
     */
    public function isLink();

    /**
     * @return bool
     */
    public function isReadable();

    /**
     * @return bool
     */
    public function isWritable();

    /**
     * @return \SplFileObject
     */
    public function openFile();

    /**
     * @param string|null $className
     * @return void
     */
    public function setFileClass($className = null);

    /**
     * @param string|null $className
     * @return void
     */
    public function setInfoClass($className = null);

    /**
     * @return void
     */
    public function __toString();




    /**
     * Methods we defined
     */

    /**
     * @return int
     */
    public function getReadablePermissions();

    /**
     * Returns an array of all the files that are in the directory
     * @return array
     */
    public function getSubfiles();

    /**
     * @return File
     */
    public function getParent();

}