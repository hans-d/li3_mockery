<?php

namespace li3_mockery\test;

/**
 * Get the \Mockery class in a li3 accessible class, with some extras.
 *
 */
class Mockery extends \lithium\core\StaticObject {

	/**
	 * Holds the class names for the generated mocks.
	 *
	 * @var unknown_type
	 */
	protected static $_lookup = array();

	/**
	 * Shortcut to calling methods defined in `\Mockery`
	 */
	public static function __callStatic($name, $arguments) {
		return self::invokeMethodOn($name, '\Mockery', $arguments);
	}

	/**
	 * Variation on Lithium's `invokeMethod`, allows to set on which class to invoke the Method.
	 *
	 * @see invokeMethod()
	 * @param unknown_type $method
	 * @param unknown_type $class
	 * @param unknown_type $params
	 */
	public static function invokeMethodOn($method, $class, $params = array()) {
		if (isset(self::$_classes) && isset(self::$_classes[$class])) {
			$class = self::$_classes[$class];
		}
		switch (count($params)) {
			case 0:
				return $class::$method();
			case 1:
				return $class::$method($params[0]);
			case 2:
				return $class::$method($params[0], $params[1]);
			case 3:
				return $class::$method($params[0], $params[1], $params[2]);
			case 4:
				return $class::$method($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $class::$method($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return forward_static_call_array(array($class, $method), $params);
		}
	}

	/**
	 * Generate and store mocks with their mock class names.
	 *
	 * This is used for alias or overload mocks. The class names can be
	 * passed and later used in the application to create a new object
	 * that happens to be the mock.
	 *
	 * @see aliasMock()
	 * @see overloadMock()
	 */
	protected static function _mock($class, array $options = array()) {
		$options += array(
				'unique' => 'true',
				'type' => 'mock',
				'subtype' => false,
				'namespace' => true
		);
		extract($options);

		$newName = ($namespace ? $type . '\\' : '') . $class . ($unique ? uniqid() : '');
		$mock = \Mockery::$type(($subtype ? $subtype . ':' : '') . $newName);
		self::$_lookup[$class] = $newName;

		return $mock;
	}

	public static function mock($class, array $options = array()) {
		return self::_mock($class, array('type' => 'mock') + $options);
	}

	public static function instanceMock($class, array $options = array()) {
		return self::_mock($class, array('type' => 'instanceMock') + $options);
	}


	/**
	 * Generate and store an alias mock.
	 *
	 * Alias mocks are needed when static methods are to be called.
	 *
	 * @param string $name the mock reference name
	 * @return object the generated mock
	 */
	public static function aliasMock($class, array $options = array()) {
		return self::mock($class, array('subtype' => 'alias') + $options);
	}

	/**
	 * Generate and store an overload mock.
	 *
	 * Overload mocks are needed when the object will be later instantiated.
	 * Eg: `new mock\someClass\someMethod\someName()`
	 *
	 * @param string $name the mock reference name
	 * @return object the generated mock
	 */
	public static function overloadMock($name, array $options=array()) {
		return self::mock($name, array('subtype' => 'overload') + $options);
	}

	/**
	 * Static shortcut to closing up and verifying all mocks in the global
	 * container, and resetting the container static variable to null
	 *
	 * @return void
	 */
	public static function close()
	{
                \Mockery::close();
                self::$_lookup = array();
	}

	public static function fetchMock($name) {
		$alias = self::$_lookup[$name];
		return \Mockery::fetchMock($alias);
	}

        public static function fetchMockClass($name) {
                return self::$_lookup[$name];
        }

	public static function resetContainer() {
                \Mockery::resetContainer();
                self::$_lookup = array();
	}

}
