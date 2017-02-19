<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;


/**
 * @Author: Alexey Kutuzov <lexus.1995@mail.ru>
 * Interface Service
 * @package Jungle\DependencyInjection
 */
interface Service{

	/**
	 * @param Container $container
	 * @param $as_name
	 * @return object
	 */
	public function resolve(Container $container, $as_name);

}

