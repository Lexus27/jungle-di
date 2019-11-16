<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Containers;

use Jungle\DependencyInjection\Container;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class ExtendableContainer
 * @package Jungle\DependencyInjection\Containers
 */
class ExtendableContainer extends DefinableContainer{

	/** @var  Container */
	protected $ancestor;

	/**
	 * @param Container $ancestor
	 * @return $this
	 */
	public function setAncestor(Container $ancestor){
		$this->ancestor = $ancestor;
		return $this;
	}

	/**
	 * @return Container
	 */
	public function getAncestor(){
		return $this->ancestor;
	}


    /**
     * @param $identifier
     * @return null|object
     * @throws \Jungle\DependencyInjection\DIException
     */
	public function get($identifier){
		$service = parent::get($identifier);
		if(!$service && $this->ancestor){
			return $this->ancestor->get($identifier);
		}
		return $service;
	}


	/**
	 * @param $identifier
	 * @return bool
	 */
	public function has($identifier){
		if(!($has = parent::has($identifier)) && $this->ancestor){
			return $this->ancestor->has($identifier);
		}
		return $has;
	}

}


