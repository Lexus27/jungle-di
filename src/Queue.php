<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Queue
 * @package Jungle\DependencyInjection
 */
class Queue extends QueueAbstract{

	const BASE_DEFAULT  = 'default';
	const BASE_SELF     = 'self';



	protected $base;

	protected $base_default_mode = self::BASE_SELF;

	/**
	 * @param $identifier
	 * @return null
	 */
	public function get($identifier){
		$this->_sort();
		foreach($this->injections_ordered as $id => $container){
			if($service = $container->get($identifier)){
				return $service;
			}
		}
		return null;
	}

	/**
	 * @param $identifier
	 * @return bool
	 */
	public function has($identifier){
		$this->_sort();
		foreach($this->injections_ordered as $id => $container){
			if($service = $container->has($identifier)){
				return $service;
			}
		}
		return false;
	}

	/**
	 * @param $identifier
	 * @param $service
	 * @return $this
	 * @throws DIException
	 */
	public function set($identifier, $service){
		if($container = $this->getInjection(self::DEFAULT_ID)){
			$container->set($identifier, $service);
		}else{
			throw DIException::queueDefaultNotDefined('Set service "'.$identifier.'" automatically to "default" injection');
		}
		return $this;
	}

	/**
	 * @param $identifier
	 * @return $this
	 */
	public function remove($identifier){
		if($container = $this->getInjection(self::DEFAULT_ID)){
			$container->remove($identifier);
		}
		return $this;
	}

	/**
	 * @param Container|null $container
	 * @return $this
	 */
	public function setBase(Container $container = null){
		$this->base = $container;
		return $this;
	}

	/**
	 * @return Container|null
	 */
	public function getBase(){
		return $this->base?:$this;
	}

	/**
	 * @param string $mode
	 * @return $this
	 */
	public function setBaseDefaultMode($mode = self::BASE_SELF){
		if(!in_array($mode, [self::BASE_DEFAULT, self::BASE_SELF], true)){
			DIException::queueBadBaseDefaultMode($mode);
		}
		$this->base_default_mode = $mode;
		return $this;
	}
}


