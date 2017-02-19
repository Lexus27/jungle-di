<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */

namespace Jungle\DependencyInjection;
use Jungle\DependencyInjection\Exceptions\ServiceNotFoundException;


/**
 * @Author: Alexey Kutuzov <lexus27.khv@gmail.com>
 * Class DIException
 * @package Jungle\DependencyInjection
 */
class DIException extends \Exception{

	/**
	 * @param $service_name
	 * @param $class_name
	 * @return DIException
	 */
	public static function notFoundClass($service_name, $class_name){
		return new self('Service "'.$service_name.'" error: Class not found "'.$class_name.'"');
	}

	/**
	 * @param $service_name
	 * @return DIException
	 */
	public static function notExistsService($service_name){
		return new ServiceNotFoundException(sprintf('Service "%s" not exists', $service_name), $service_name);
	}

	/**
	 * @param $service_name
	 * @param $definition
	 * @param $hint
	 * @return DIException
	 */
	public static function badDefinitionService($service_name, $definition, $hint){
		return new self('Service "'.$service_name.'" bad definition format must be: '.$hint.'; but passed: '.var_export($definition, true));
	}

	/**
	 * @param $service_name
	 * @param $definition
	 * @param $hint
	 * @return DIException
	 */
	public static function badService($service_name, $definition, $hint){
		return new self('Service "'.$service_name.'" resolved, but result is not valid given: '.$hint.'; definition: '.var_export($definition, true));
	}

	/**
	 * @param $message
	 * @return DIException
	 */
	public static function queueDefaultNotDefined($message){
		return new self('QueueError: Default is not defined! action: '.$message);
	}

	/**
	 * @param $mode
	 * @return DIException
	 */
	public static function queueBadBaseDefaultMode($mode){
		return new self('QueueError: setBaseDefaultMode: '.var_export($mode,1).' is invalid, allowed: [ "default" | "self" ]');
	}
}


