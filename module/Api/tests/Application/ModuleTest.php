<?php

namespace Application\Tests;

class ModuleTest extends BaseModuleTest
{

    public function testConfig()
    {
        $this->assertNotEmpty($this->config);
        $this->assertInternalType('array', $this->config);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

}
