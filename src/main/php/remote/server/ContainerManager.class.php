<?php namespace remote\server;

/**
 * Container manager
 *
 * @purpose  Manage beancontainer
 */
class ContainerManager extends \lang\Object {
  public
    $containers= array();
  
  /**
   * Constructor
   *
   */
  public function __construct() { }
  
  /**
   * Register
   *
   * @param   remote.server.BeanContainer container
   * @return  int
   */
  public function register($container) {
    $this->containers[]= $container;
    $container->setContainerID(sizeof($this->containers)- 1);
    return sizeof($this->containers)- 1;
  }
  
  /**
   * Get a  beancontainer
   *
   * @param   int oid
   * @return var
   */
  public function getContainerByOID($oid) {

    // TDB
  }
}
