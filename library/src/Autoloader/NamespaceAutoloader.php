<?php

class NamespaceAutoloader
{
    protected $namespacesMap = [];

    public function __construct()
    {
        $this->addNamespace('Framework', ROOT . DS . 'library' . DS . 'src');
        $modulesConfig = require_once (ROOT . DS . 'config' . DS . 'modules.php');
        foreach ($modulesConfig as $namespace){
            $this->addNamespace($namespace, ROOT . DS . 'application' . DS . 'module' . DS . $namespace . DS . 'src');
        }

    }

    /**
     * @param string $namespace
     * @param string $rootDir
     *
     * @return bool
     */
    public function addNamespace($namespace, $rootDir)
    {
        if (is_dir($rootDir)) {
            $this->namespacesMap[$namespace] = $rootDir;
            return true;
        }

        return false;
    }

    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    protected function autoload($class)
    {
        $pathParts = explode('\\', $class);

        if (is_array($pathParts)) {
            $namespace = array_shift($pathParts);

            if (!empty($this->namespacesMap[$namespace])) {
                $filePath = $this->namespacesMap[$namespace] . '/' . implode('/', $pathParts) . '.php';
                require_once $filePath;
                return true;
            }
        }

        return false;
    }
}