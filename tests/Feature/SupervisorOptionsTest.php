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
        // Set the static pausable property on the worker instance
        $workerClass = get_class($this->worker());
        $workerClass::$pausable = true;

        $this->assertTrue($workerClass::$pausable);

        // Now simulate Horizon copying it to SupervisorOptions
        $options = new SupervisorOptions('name', 'redis');

        // Expect the dynamic property deprecation
        $this->expectDeprecation();
    }
}
