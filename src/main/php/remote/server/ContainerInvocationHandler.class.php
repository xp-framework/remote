<?php namespace remote\server;

use lang\reflect\InvocationHandler;


/**
 * Container invocation handler
 *
 * @purpose  invocation handler
 */
class ContainerInvocationHandler extends \lang\Object implements InvocationHandler {
  public
    $container  = null;
  
  /**
   * Set container
   *
   * @param   remote.server.BeanContainer container
   */
  public function setContainer($container) {
    $this->container= $container;
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

    // TBD Invocation interceptors
    return $this->container->invoke($proxy, $method, $args);
  }

} 
