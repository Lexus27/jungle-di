<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Exceptions;

use Jungle\DependencyInjection\DIException;


/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class ServiceNotFoundException
 * @package Jungle\DependencyInjection\Exceptions
 */
class ServiceNotFoundException extends DIException implements ServiceAwareException{

	/** @var int  */
	private $service_name;

	/**
	 * ServiceNotFoundException constructor.
	 * @param string $message
	 * @param string $service_name
	 */
	public function __construct($message, $service_name){
		parent::__construct($message,0,null);
		$this->service_name = $service_name;
	}

	/**
	 * @return int|string
	 */
	public function getService(){
		return $this->service_name;
	}

	/**
	 * @return null
	 */
	public function getDefinition(){
		return null;
	}

}


