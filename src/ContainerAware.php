<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;

/**
 * @Author: Alexey Kutuzov <lexus.1995@mail.ru>
 * Interface ContainerAware
 * @package Jungle\DependencyInjection
 */
interface ContainerAware{

	/**
	 * @param Container $di
	 * @return void
	 */
	public function setDi(Container $di);

	/**
	 * @return Container
	 */
	public function getDi();

	/**
	 * @return Container
	 */
	public function getAttachedDi();

}


