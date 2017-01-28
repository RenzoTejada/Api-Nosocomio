<?php

namespace Api\Tests;

use Api\Module as ApiModule,
    Application\Tests\Bootstrap,
    Zend\ServiceManager\Config as ServiceConfig,
    Zend\ServiceManager\ServiceManager;

abstract class BaseModuleTest extends \PHPUnit_Framework_TestCase
{

    protected $config;
    protected $serviceManager;

    public function setUp()
    {
        parent::setUp();

        defined("DS") || define("DS", DIRECTORY_SEPARATOR);
        defined("PUBLIC_PATH") || define("PUBLIC_PATH",
                __DIR__ . '/../../../../public');
        defined("ELEMENT_PATH") || define("ELEMENT_PATH",
                PUBLIC_PATH . '/elements/');

        $module = new ApplicationModule();
        $this->assertInternalType('array', $module->getConfig());

        $this->config = $module->getConfig();

        $serviceConfig = new ServiceConfig($this->config['service_manager']);
        $this->assertInstanceOf('Zend\ServiceManager\Config', $serviceConfig);

        $this->serviceManager = new ServiceManager($serviceConfig);
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManager',
            $this->serviceManager);
        $this->serviceManager->setService('config', $this->config);
        $this->serviceLocator = Bootstrap::getServiceManager();
    }

    protected function createServiceManagerForTest()
    {
        $serviceConfig = new ServiceConfig($this->config['service_manager']);
        $serviceManager = new ServiceManager($serviceConfig);

        return $serviceManager;
    }

}
