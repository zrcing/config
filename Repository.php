<?php
/**
 * @author Liao Gengling <liaogling@gmail.com>
 */
namespace Planfox\Component\Config;

use Planfox\Component\Config\Exception\Exception;

class Repository implements RepositoryInterface
{
    /**
     * @var string config root directory
     */
    protected $directory;

    protected $configures = [];


    public function __construct($directory = null)
    {
        if (! is_null($directory)) {
            $this->directory = $directory;
            $this->init();
        }
    }

    /**
     * set directory of configuration
     *
     * @param string $directory Absolute path
     * @return mixed
     * @throws
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
        $this->init();

        return $this;
    }

    /**
     * Initialize
     *
     * @throws
     */
    protected function init()
    {
        if (is_null($this->directory)) {
            throw new Exception('The configure directory does not exist.');
        }
        $files = glob( $this->directory . DIRECTORY_SEPARATOR ."*.php");
        foreach ($files as $file) {
            if (is_file($file)) {
                $fileinfo = pathinfo($file);
                $this->configures[$fileinfo['filename']] = require $file;
            }
        }
    }

    /**
     * Get the path of configure directory
     *
     * @return mixed
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     *
     * Get config value
     *
     * @param null|string $key
     * @return mixed
     */
    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->configures;
        }
        $info = explode('.', $key);
        $access = array_reduce($info, function ($r, $a) {
            return $r ? "{$r}['{$a}']" : "['{$a}']";
        });
        $code = "if(is_null(\$this->configures{$access})){\$r=null;}else{\$r=\$this->configures{$access};}";
        eval($code);

        return $r;
    }

    /**
     * Set config value
     *
     * @param string $key
     * @param mixed $vars
     * @return mixed
     * @throws
     */
    public function set($key, $vars)
    {
        if (is_null($key) || $key == '') {
            throw new Exception('The key does not exist.');
        }
        $info = explode('.', $key);
        $access = array_reduce($info, function ($r, $a) {
            return $r ? "{$r}['{$a}']" : "['{$a}']";
        });
        $code = "\$this->configures{$access}=\$vars;";
        eval($code);
    }
}