<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Tests;

use Jungle\DependencyInjection\Containers\SimpleContainer;
use Jungle\DependencyInjection\Queue;

class QueueTest extends \PHPUnit_Framework_TestCase{

	
	public function testQueue(){
		$queue = new Queue();

		$queue->setDefault($default = new SimpleContainer());

		$queue->inject('last'   , $last     = new SimpleContainer() , 1);
		$queue->inject('second' , $second   = new SimpleContainer() , 5);
		$queue->inject('first'  , $first    = new SimpleContainer() , 10);

		$injections = $queue->getInjections();

		$this->assertEquals($this->getContainerPosition($injections, 'default') , 3 );
		$this->assertEquals($this->getContainerPosition($injections, 'last')    , 2 );
		$this->assertEquals($this->getContainerPosition($injections, 'second')  , 1 );
		$this->assertEquals($this->getContainerPosition($injections, 'first')   , 0 );

	}

	public function testQueueComplex(){
		$queue = new Queue();
		
		/**
		 * Queue:
		 * 1: @last
		 * 2: @second
		 * 3: @first
		 * 4: @default
		 */
		
		$queue->setDefault($default = new SimpleContainer());
		
		
		$queue->inject('last'   , $last     = new SimpleContainer() , 1);
		$queue->inject('second' , $second   = new SimpleContainer() , 5);
		$queue->inject('first'  , $first    = new SimpleContainer() , 10);

		
		
		
		$c1 = new \stdClass();
		$c1->a = 1;

		$c2 = new \stdClass();
		$c2->a = 5;
		
		
		/**
		 * Set in @first: "std" = {a: 5}
		 */
		$queue->getInjection('first')
			->set('std', $c2);
		
		
		/**
		 * Set in @last: "std" = {a: 1}
		 */
		$queue->getInjection('last')
			->set('std', $c1);
		
		
		/**
		 * @var \stdClass $service
		 */
		$service = $queue->get('std');
		$this->assertInstanceOf(\stdClass::class, $service );
		$this->assertEquals(5, $service->a);
		
		
		/**
		 * restore prev state for 'first' injection
		 * else if prev state not exists then will removed current 'first'
		 */
		$queue->restore('first');
		
		
		/**
		 * @var \stdClass $service
		 */
		$service = $queue->get('std');
		$this->assertInstanceOf(\stdClass::class, $service );
		$this->assertEquals(1, $service->a);
	}

	public function getContainerPosition($injections, $name){
		return array_search($name, array_keys($injections), true);
	}

}


