<?php

namespace app\tests\cases\test;

use li3_mockery\test\Mockery as m;

class MockeryTest extends \lithium\test\Unit {

	public function tearDown() {
		m::close();
	}

	public function testMock() {
		$mock = m::mock('test');
		$mock->shouldReceive('go')->twice()->andReturn(1);

		$result = $mock->go();
		$expected = 2;
		$this->assertEqual($expected, $result);

	}

	public function testSimple() {
		$this->assertEqual(1, 2);
	}


}