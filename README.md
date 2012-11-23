# li3_mockery

The mockery framework via a lithium plugin

## Installation

### Composer
~~~ json
{
    "require": {
        ...
        "blainesch/li3_mockery": "dev-master"
        ...
    }
}
~~~
~~~ bash
php composer.phar install
~~~

### Submodule
~~~ bash
git submodule add git://github.com/BlaineSch/li3_mockery.git libraries/li3_mockery
~~~

### Clone Directly
~~~ bash
git clone git://github.com/BlaineSch/li3_mockery.git libraries/li3_mockery
~~~

## Usage

### Load the plugin

Add the plugin to be loaded with Lithium's autoload magic

In `app/config/bootstrap/libraries.php` add:

~~~ php
<?php
	Libraries::add('li3_mockery');
?>
~~~

Within your tests call mockery:

~~~ php
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
?>
~~~