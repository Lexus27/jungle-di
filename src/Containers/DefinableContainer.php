<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Containers;


use Jungle\DependencyInjection\ContainerAware;
use Jungle\DependencyInjection\DIException;
use Jungle\DependencyInjection\Service;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class DefinableContainer
 * @package Jungle\DependencyInjection\Containers
 */
class DefinableContainer extends SimpleContainer{

	/** @var  array */
	protected $definitions = [];

	/**
	 * @param $identifier
	 * @return object|null
	 * @throws DIException
	 */
	public function get($identifier){
		if(isset($this->services[$identifier])){
			$object = $this->services[$identifier];

			if($object instanceof Service){
				return $object->resolve($this, $identifier);
			}

			return $object;
		}
		if(isset($this->definitions[$identifier])){
			$object = $this->_build($identifier, $this->definitions[$identifier]);
			if(!is_object($object)){
				DIException::badService($identifier, $this->definitions[$identifier], var_export($object, true));
			}elseif($object instanceof ContainerAware){
				$object->setDi($this);
			}
			$this->services[$identifier] = $object;

			if($object instanceof Service){
				$object = $object->resolve($this, $identifier);
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
		return isset($this->services[$identifier]) ||
		       isset($this->definitions[$identifier]);
	}

	/**
	 * @param $identifier
	 * @param $definition
	 * @return $this
	 */
	public function set($identifier, $definition){
		if(!isset($this->definitions[$identifier]) || $this->definitions[$identifier] !== $definition){
			$this->definitions[$identifier] = $definition;
			unset($this->services[$identifier]);
		}
		return $this;
	}

	/**
	 * @param $identifier
	 * @return $this
	 */
	public function remove($identifier){
		unset(
			$this->services[$identifier],
			$this->definitions[$identifier]
		);
		return $this;
	}



	/**
	 * @param $service_name
	 * @param $definition
	 * @return mixed
	 * @throws DIException
	 */
	protected function _build($service_name, $definition){
		if($definition instanceof \Closure){
			$object = call_user_func($definition, $this);
		}elseif(is_object($definition)){
			$object = $definition;
		}elseif(is_string($definition)){
			$object = $this->_instantiateFromClass($service_name, $definition, []);
		}elseif(is_array($definition)){
			$definition = array_replace([
				'arguments' => [],
				'class'     => null,
				'static'    => false
			],$definition);
			$arguments  = $definition['arguments'];
			$class      = $definition['class'];
			$static     = $definition['static'];

			if(!$class){
				throw DIException::badDefinitionService(
					$service_name, $definition,
					'[ "arguments": array; "class": string(required); "static": string(method name) | false ]'
				);
			}
			if($static){
				$object = $this->_instantiateFromStatic($service_name, $class, $static, $arguments);
			}else{
				$object = $this->_instantiateFromClass($service_name, $class, $arguments);
			}
		}else{
			throw DIException::badDefinitionService(
				$service_name, $definition,
				'\Closure || object || string(className) || array[ "arguments": array; "class": string(required); "static": string(method name) | false ]'
			);
		}

		return $object;
	}


	/**
	 * @param $service_name
	 * @param $class_name
	 * @param $arguments
	 * @return mixed
	 * @throws DIException
	 */
	protected function _instantiateFromClass($service_name, $class_name, $arguments){
		if(!class_exists($class_name)){
			throw DIException::notFoundClass($service_name, $class_name);
		}
		return new $class_name(...$arguments);
	}

	/**
	 * @param $service_name
	 * @param $class_name
	 * @param $method
	 * @param $arguments
	 * @return mixed
	 * @throws DIException
	 */
	protected function _instantiateFromStatic($service_name, $class_name, $method, $arguments){
		if(!class_exists($class_name)){
			throw DIException::notFoundClass($service_name, $class_name);
		}
		return $class_name::$method(...$arguments);
	}



}


