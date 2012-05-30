<?php

namespace li3_mockery\tests\cases\test;

use li3_mockery\test\Mockery as m;


/**
 * Run the sample as found on https://github.com/padraic/mockery
 *
 */
class MockeryTest extends \lithium\test\Unit {

	public function tearDown() {
		m::close();
	}

	public function testGetsAverageTemperatureFromThreeServiceReadings()
	{
		$service = m::mock('service');
		$service->shouldReceive('readTemp')->times(3)->andReturn(10, 12, 14);

		$temperature = new Temperature($service);
		$this->assertEqual(12, $temperature->average());
	}
}

/**
 * Sample class to mock, as found on https://github.com/padraic/mockery
 *
 */
class Temperature {

	public function __construct($service) {
		$this->_service = $service;
	}

	public function average() {
		$total = 0;
		for ($i=0; $i<3; $i++) {
			$total += $this->_service->readTemp();
		}
		return $total/3;
	}

}

?>