<?php
namespace Gone\AppCore\Tests;

use Gone\AppCore\App;
use Gone\AppCore\Exceptions\GeneralException;
use Gone\Testing\TestCase;

class AppTest extends TestCase
{
    /** @var App */
    private $app;

    public function setUp()
    {
        parent::setUp();

        $reflection = new \ReflectionClass(App::class);
        $this->app = $reflection->newInstanceWithoutConstructor();
    }


    public function testSetup_noAppRootSet()
    {
        $this->expectException(GeneralException::class);
        $this->expectExceptionMessage("APP_ROOT has not been defined.");
        $this->app->setup();
    }

    public function testSetup_noAppStartSet()
    {
        define("APP_ROOT", $_SERVER['PWD']);
        $this->app->setup();
        $this->assertTrue(defined("APP_START"));
        $this->assertTrue(defined("APPCORE_ROOT"));
        $this->assertTrue(defined("DEFAULT_ROUTE_ACCESS_MODE"));
    }

    public function testSetupDependencies()
    {
        $this->app->setupDependencies();
    }
}