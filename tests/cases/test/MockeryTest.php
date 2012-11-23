<?php

namespace li3_mockery\tests\cases\test;

use li3_mockery\test\Mockery;

class MockeryTest extends \lithium\test\Unit {

	public function tearDown() {
		Mockery::close();
	}

	public function testMock() {
		$mock = Mockery::mock('test');
		$mock->shouldReceive('go')->twice()->andReturn(1);

		$result = $mock->go();
		$result += $mock->go();
		$expected = 2;
		$this->assertEqual($expected, $result);

	}

}