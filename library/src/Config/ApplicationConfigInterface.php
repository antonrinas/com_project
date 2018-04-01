<?php

namespace Framework\Config;

interface ApplicationConfigInterface
{
    /**
     * @param bool $directCall
     * @throws ApplicationConfigException
     */
    public function __construct($directCall = true);

    /**
     * @return ApplicationConfigInterface
     *
     * @throws ApplicationConfigException
     */
    public static function getInstance();

    /**
     * @return ConfigInterface
     *
     * @throws ApplicationConfigException
     */
    public function getGlobalConfig();

    /**
     * @return ConfigInterface
     *
     * @throws ApplicationConfigException
     */
    public function getDbConfig();

    /**
     * @return ConfigInterface
     *
     * @throws ApplicationConfigException
     */
    public function getModulesConfig();

    /**
     * @return ConfigInterface
     *
     * @throws ApplicationConfigException
     */
    public function getRoutesConfig();
}