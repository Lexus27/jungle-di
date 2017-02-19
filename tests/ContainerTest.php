<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Tests;


use Jungle\DependencyInjection\Containers\DefinableContainer;
use Jungle\DependencyInjection\Containers\SimpleContainer;

class ContainerTest extends \PHPUnit_Framework_TestCase{

	public function testSimpleContainer(){

		$container = new SimpleContainer();
		$container->set('std', new \stdClass() );

		$this->assertTrue($container->has('std'), 'service "std" not found!');

		$container->remove('std'); // remove service "std"

		$this->assertFalse($container->has('std'), 'service "std" not removed!');

	}

	public function testDefinableContainer(){

		$container = new DefinableContainer();
		$container->set('std', 'stdClass');

		$service = $container->get('std');

		$this->assertEquals('stdClass', get_class($service),'ClassName Definition: service [std] is not a "strClass" instance');

		$container->set('std', [
			'class' => 'stdClass'
		]);

		$service = $container->get('std');

		$this->assertEquals('stdClass', get_class($service), 'Array Definition: service [std] is not a "strClass" instance');

		$container->remove('std');

		$this->assertFalse($container->has('std'), 'service "std" not removed!');

		$container->set('example', [
			'class' => 'Jungle\DependencyInjection\Tests\ExampleService',
			'arguments' => ['a1','a2']
		]);

		$service = $container->get('example');
		$this->assertEquals(
			'Jungle\DependencyInjection\Tests\ExampleService',
			get_class($service),
			'Array with args: service [example] '.
			'is not a "Jungle\DependencyInjection\Tests\ExampleService" instance '
		);
		$this->assertEquals('a1', $service->arg1, 'Argument [0] for constructor, not expected value');
		$this->assertEquals('a2', $service->arg2, 'Argument [1] for constructor, not expected value');


		$container->set('example', [
			'class' => 'Jungle\DependencyInjection\Tests\ExampleService',
			'static' => 'instantiate',
			'arguments' => ['arg_value1','arg_value2']
		]);

		$service = $container->get('example');
		$this->assertEquals(
			'Jungle\DependencyInjection\Tests\ExampleService',
			get_class($service),
			'Array static method and Args: service [example] '.
			'is not a "Jungle\DependencyInjection\Tests\ExampleService" instance '
		);

		$this->assertEquals('arg_value1', $service->arg1, 'Argument [0] for constructor, not expected value');
		$this->assertEquals('arg_value2', $service->arg2, 'Argument [1] for constructor, not expected value');


		$container->remove('example');

		$this->assertFalse($container->has('example'), 'service "example" not removed!');

	}

}


