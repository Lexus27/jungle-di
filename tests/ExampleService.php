<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Tests;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class ExampleService
 * @package Jungle\DependencyInjection\Tests
 */
class ExampleService{

	public $arg1;

	public $arg2;

	public function __construct($arg1, $arg2){

		$this->arg1 = $arg1;
		$this->arg2 = $arg2;
	}

	public static function instantiate($arg1, $arg2){
		return new self($arg1,$arg2);
	}

}


