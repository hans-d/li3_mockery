<?php

namespace li3_mockery\tests\cases\test;

use li3_mockery\test\Mockery,
	li3_mockery\tests\mocks\TemperatureMock;


/**
 * Run the sample as found on https://github.com/padraic/mockery
 *
 */
class MockeryExampleTest extends \lithium\test\Unit {

	public function tearDown() {
		Mockery::close();
	}

	public function testGetsAverageTemperatureFromThreeServiceReadings() {
		$service = Mockery::mock('service');
		$service->shouldReceive('readTemp')->times(3)->andReturn(10, 12, 14);

		$temperature = new TemperatureMock($service);
		$this->assertEqual(12, $temperature->average());
	}
}