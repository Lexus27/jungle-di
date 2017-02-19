<?php
/**
 * @created Alexey Kutuzov <lexus27.khv@gmail.com>
 * @Project: php-di
 */
namespace Jungle\DependencyInjection;
use Jungle\DependencyInjection\Containers\SimpleContainer;

include '../vendor/autoload.php';

$queue = new Queue();

$queue->setDefault($default = new SimpleContainer());

$queue->inject('last'   , $last     = new SimpleContainer() , 1);
$queue->inject('second' , $second   = new SimpleContainer() , 5);
$queue->inject('first'  , $first    = new SimpleContainer() , 10);
$injections = $queue->getInjections();