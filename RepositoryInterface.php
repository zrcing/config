<?php
/**
 * @author Liao Gengling <liaogling@gmail.com>
 */

namespace Planfox\Component\Config;

interface RepositoryInterface
{
    /**
     * set directory of configuration
     *
     * @param string $directory Absolute path
     * @return mixed
     */
    public function setDirectory($directory);

    /**
     * Get directory of configuration
     *
     * @return mixed
     */
    public function getDirectory();

    /**
     *
     * Get config value
     *
     * @param null|string $key
     * @return mixed
     */
    public function get($key = null);

    /**
     * Set config value
     *
     * @param string $key
     * @param mixed $vars
     * @return mixed
     * @throws
     */
    public function set($key, $vars);
}