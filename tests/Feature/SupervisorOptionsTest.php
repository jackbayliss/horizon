<?php

namespace Laravel\Horizon\Tests\Feature;

use Laravel\Horizon\SupervisorOptions;
use Laravel\Horizon\Tests\IntegrationTest;

class SupervisorOptionsTest extends IntegrationTest
{
    public function test_default_queue_is_used_when_null_is_given()
    {
        $options = new SupervisorOptions('name', 'redis');
        $this->assertSame('default', $options->queue);
    }

    public function test_dynamic_property_warning_from_worker_pausable()
    {
        if (version_compare($this->app->version(), '12.41.0', '<')) {
            $this->markTestSkipped('This test is not valid for Laravel < 12.41.0.');
        }
        echo $this->app->version();
        $workerClass = get_class($this->worker());
        if(property_exists($workerClass, '$pausable')) {
            $workerClass::$pausable = false;
            $this->assertFalse($workerClass::$pausable);
        }

        // Now simulate Horizon copying it to SupervisorOptions
        $options = new SupervisorOptions('name', 'redis');
    }
}
