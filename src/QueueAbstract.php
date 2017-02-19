<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class QueueAbstract
 * @package Jungle\DependencyInjection
 */
abstract class QueueAbstract{

	const DEFAULT_ID        = 'default';
	const DEFAULT_PRIORITY  = 0.0;

	/** @var array[]|Container[]  */
	protected $injections_history = [];

	/** @var array  */
	protected $injections_priority = [];

	/** @var Container[]  */
	protected $injections = [];

	/** @var  Container[]|null */
	protected $injections_ordered;


	/**
	 * QueueAbstract constructor.
	 * @param Container|null $default
	 */
	public function __construct(Container $default = null){
		if($default)$this->setDefault($default);
	}

	/**
	 * @param Container $container
	 */
	public function setDefault(Container $container){
		unset($this->injections_history[self::DEFAULT_ID]);
		$this->injections[self::DEFAULT_ID] = $container;
		$this->injections_priority[self::DEFAULT_ID] = self::DEFAULT_PRIORITY;
		$this->injections_ordered = null;
	}

	/**
	 * @param $injection_id
	 * @param Container $container
	 * @param $priority
	 */
	public function inject($injection_id, Container $container, $priority = 0.0){
		if(isset($this->injections[$injection_id])){
			$this->injections_history[$injection_id][] = $this->injections[$injection_id];
			if($priority === null){
				$priority = $this->injections_priority[$injection_id];
			}
			if($this->injections_priority[$injection_id] !== $priority){
				$this->injections_ordered = null;
			}elseif(isset($this->injections_ordered[$injection_id])){
				$this->injections_ordered[$injection_id] = $container;
			}
		}elseif($priority === null){
			$priority = 0.0;
		}
		$this->injections[$injection_id] = $container;
		$this->injections_priority[$injection_id] = $priority;
	}

	/**
	 * @param $injection_id
	 * @return Container|null
	 */
	public function getInjection($injection_id){
		return isset($this->injections[$injection_id])?$this->injections[$injection_id]:null;
	}

	/**
	 * @return Container[]
	 */
	public function getInjections(){
		$this->_sort();
		return $this->injections_ordered;
	}

	/**
	 * @param $injection_id
	 * @param double $priority
	 * @return Container|null
	 */
	public function setInjectionPriority($injection_id, $priority = 0.0){
		if(isset($this->injections[$injection_id]) && $this->injections_priority[$injection_id] !== $priority){
			$this->injections_priority[$injection_id] = $priority;
			$this->injections_ordered = null;
		}
		return $this;
	}
	/**
	 * @param $injection_id
	 * @return Container|null
	 */
	public function getInjectionPriority($injection_id){
		return isset($this->injections_priority[$injection_id])?$this->injections_priority[$injection_id]:null;
	}


	/**
	 * @param $injection_id
	 * @return Container|null
	 */
	public function restore($injection_id){
		$container = null;
		if(isset($this->injections_history[$injection_id])){
			$container = array_pop($this->injections_history[$injection_id]);
			if(!$this->injections_history[$injection_id]){
				unset($this->injections_history[$injection_id]);
			}
		}

		$current = null;
		if(isset($this->injections[$injection_id])){
			$current = $this->injections[$injection_id];
		}

		if(isset($this->injections_ordered[$injection_id])){
			if($container){
				$this->injections_ordered[$injection_id] = $container;
			}else{
				unset($this->injections_ordered[$injection_id]);
			}
		}

		if(isset($container)){
			$this->injections[$injection_id] = $container;
		}else{
			unset($this->injections[$injection_id]);
		}

		return $current;
	}

	public function clear($injection_id){
		unset(
			$this->injections[$injection_id],
			$this->injections_ordered[$injection_id],
			$this->injections_history[$injection_id],
			$this->injections_priority[$injection_id]
		);
	}


	protected function _sort(){
		if(!isset($this->injections_ordered)){
			$a = $this->injections;
			uksort($a, [$this,'_sort_cmp']);
			$this->injections_ordered = $a;
		}
	}

	protected function _sort_cmp($id_a,$id_b){
		$a = $this->injections_priority[$id_a];
		$b = $this->injections_priority[$id_b];

		if($id_a !== self::DEFAULT_ID) $a++;
		if($id_b !== self::DEFAULT_ID) $b++;

		if($a === null){
			return 0;
		}
		return $a > $b? -1 : 1 ;
	}

}


