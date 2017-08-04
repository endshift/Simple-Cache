<?php
/**
 * Created by PhpStorm.
 * User: jaredchu
 * Date: 04/08/2017
 * Time: 11:36
 */

namespace JC;

/**
 * Class CacheManager
 * @package JC
 *
 * Manage the list of caching file and object
 * Save in $cFilename
 */
class CacheManager
{
    /**
     * @var string
     */
    public static $cFileName = 'jc-simple-cache-list';

    /**
     * @param $cFileName
     */
    public static function setCFileName($cFileName)
    {
        static::$cFileName = $cFileName;
    }

    /**
     * @return string
     */
    public static function getCFileName()
    {
        return static::$cFileName;
    }

    /**
     * @return string
     *
     * Return absolute file path which store cache list
     */
    public static function getCFilePath()
    {
        return sys_get_temp_dir() . '/' . static::getCFileName();
    }

    /**
     * @param $key
     * @return bool|string
     *
     * Return absolute file path of caching object
     */
    public static function get($key)
    {
        $cacheList = static::getCacheList();
        if (isset($cacheList[$key])) {
            return $cacheList[$key];
        }

        return false;
    }

    /**
     * @param $key
     * @param $filePath
     * @return bool
     */
    public static function set($key, $filePath)
    {
        $cacheList = static::getCacheList();
        $cacheList[$key] = $filePath;

        return static::setCacheList($cacheList);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        $cacheList = static::getCacheList();
        unset($cacheList[$key]);

        return static::setCacheList($cacheList);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        $cacheList = static::getCacheList();
        return array_key_exists($key, $cacheList);
    }

    /**
     * @return array
     */
    protected static function getCacheList()
    {
        if (file_exists(static::getCFilePath())) {
            return json_decode(file_get_contents(static::getCFilePath()), true);
        }

        return array();
    }

    /**
     * @param $cacheList
     * @return bool
     */
    protected static function setCacheList($cacheList)
    {
        return (bool)file_put_contents(static::getCFilePath(), json_encode($cacheList));
    }
}