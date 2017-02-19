<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Containers;

use Jungle\DependencyInjection\Container;
use Jungle\DependencyInjection\DIException;
use Jungle\DependencyInjection\Service;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class SimpleContainer
 * @package Jungle\DependencyInjection\Containers
 */
class SimpleContainer implements Container{

	/** @var  object[] */
	protected $services = [];

	/** @var  Container|null */
	protected $base;

	/**
	 * @param $identifier
	 * @param $definition
	 * @return $this
	 * @throws DIException
	 */
	public function set($identifier, $definition){
		if(!is_object($definition)){
			throw DIException::badService($identifier, 'object', 'Passed Not Object');
		}
		$this->services[$identifier] = $definition;
		return $this;
	}

	/**
	 * @param $identifier
	 * @return object|null
	 */
	public function get($identifier){
		if(isset($this->services[$identifier])){
			$object = $this->services[$identifier];

			if($object instanceof Service){
				return $object->resolve($this, $identifier);
			}

			return $object;
		}
		return null;
	}

	/**
	 * @param $identifier
	 * @return bool
	 */
	public function has($identifier){
		return isset($this->services[$identifier]);
	}

	/**
	 * @param $identifier
	 * @return $this
	 */
	public function remove($identifier){
		unset($this->services[$identifier]);
		return $this;
	}

	/**
	 * @param Container|null $base
	 * @return $this
	 */
	public function setBase(Container $base = null){
		$this->base = $base;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function getBase(){
		return $this->base?:$this;
	}

}


