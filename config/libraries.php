<?php

use lithium\core\Libraries;

Libraries::add("Mockery", array(
	"path" => MOCKERY_LIBS . "/mockery/mockery/library",
	"bootstrap" => false,
	"prefix" => null,
));

require_once Libraries::get('Mockery', 'path') . '/Mockery.php';