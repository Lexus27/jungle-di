<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;

/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class Container
 * @package src
 */
interface Container{

	/**
	 * @param $identifier
	 * @return object|null
	 */
	public function get($identifier);

	/**
	 * @param $identifier
	 * @return bool
	 */
	public function has($identifier);


	/**
	 * @param $identifier
	 * @param $definition
	 * @return $this
	 */
	public function set($identifier, $definition);

	/**
	 * @param $identifier
	 * @return $this
	 */
	public function remove($identifier);



	/**
	 * @param Container|null $container
	 * @return $this
	 */
	public function setBase(Container $container = null);

	/**
	 * @return Container|null
	 */
	public function getBase();


}


