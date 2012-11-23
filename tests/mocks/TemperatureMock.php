<?php

namespace li3_mockery\tests\mocks;

/**
 * Sample class to mock, as found on https://github.com/padraic/mockery
 *
 */
class TemperatureMock {

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