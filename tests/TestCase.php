<?php

namespace Gabeta\CustomSmsChannels\Tests;

use Gabeta\CustomSmsChannels\CustomSmsChannelsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            CustomSmsChannelsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
