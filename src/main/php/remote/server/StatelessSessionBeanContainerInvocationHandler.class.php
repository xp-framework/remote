<?php namespace remote\server;

use lang\reflect\InvocationHandler;


/**
 * Invocation handler for stateless
 * session beans
 *
 * @purpose  invocationhandler
 */
class StatelessSessionBeanContainerInvocationHandler extends \lang\Object implements InvocationHandler {
  public
    $container  = null,
    $type       = null;
  
  /**
   * Set container
   *
   * @param   remote.server.BeanContainer container
   */
  public function setContainer($container) {
    $this->container= $container;
  }
  
  /**
   * Set type
   *
   * @param   int type
   */
  public function setType($type) {
    $this->type= $type;
  }

  /**
   * Processes a method invocation on a proxy instance and returns
   * the result.
   *
   * @param   lang.reflect.Proxy proxy
   * @param   string method the method name
   * @param   var args an array of arguments
   * @return  var
   */
  public function invoke($proxy, $method, $args) {
    return $this->container->invoke($method, $args);
  }

} 
