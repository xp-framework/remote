<?php namespace remote\server\container;

use util\collections\Vector;
use util\log\Traceable;


/**
 * Bean container
 *
 * @purpose  abstract baseclass
 */
abstract class BeanContainer extends \lang\Object implements Traceable {
  public
    $instancePool = null,
    $poolClass    = null;
  
  protected
    $cat            = null,
    $injector       = null,
    $configuration  = array();

  /**
   * Constructor
   *
   */
  protected function __construct() {
    $this->injector= new BeanInjector();
  }

  /**
   * Set trace
   *
   * @param   util.log.LogCategory cat
   */
  public function setTrace($cat) {
    $this->cat= $cat;
  }

  /**
   * Perform resource injection.
   *
   * @param   lang.Object instance
   * @param   lang.Object the given instance
   */
  protected function inject($instance) {
    foreach ($instance->getClass()->getMethods() as $method) {
      if (!$method->hasAnnotation('inject')) continue;

      $inject= $method->getAnnotation('inject');
      $this->cat && $this->cat->debug('---> Injecting', $inject['type'], 'via', $method->getName(true).'()');
      
      $method->invoke($instance, array($this->injector->injectFor($inject['type'], $inject['name'])));
    }
    return $instance;
  }

  /**
   * Get instance for class
   *
   * @param   lang.XPClass class
   * @return  remote.server.BeanContainer
   */
  public static function forClass(\lang\XPClass $class) {
    $bc= new self();
    $bc->instancePool= new Vector();
    $bc->poolClass= $class;
    return $bc;
  }

  /**
   * Invoke a method
   *
   * @param   lang.Object proxy
   * @param   string method
   * @param   var args
   * @return  var
   */
  public abstract function invoke($proxy, $method, $args);
}
