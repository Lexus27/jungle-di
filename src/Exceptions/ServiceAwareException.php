<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection\Exceptions;

/**
 * @Author: Alexey Kutuzov <lexus.1995@mail.ru>
 * Interface ServiceAwareException
 * @package Jungle\DependencyInjection\Exceptions
 */
interface ServiceAwareException{

	public function getService();

	public function getDefinition();

}


