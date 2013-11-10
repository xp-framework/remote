<?php namespace remote\server;

use util\Hashmap;


/**
 * Instance pool
 *
 * @purpose  Hold instances of deployed beans
 */
class InstancePool extends \lang\Object {
  public
    $_pool    = null,
    $_h2id    = null;

  /**
   * Constructor
   *
   */
  public function __construct() {
    $this->_pool= new Hashmap();
  }
    
  /**
   * Register a new instance
   *
   * @param   lang.Object object
   * @return  bool
   */
  public function registerInstance($object) {
    $this->_pool->putref($object->hashCode(), $object);
    return true;
  }
  
  /**
   * Fetch
   *
   * @param   string hashcode
   * @return  var
   */
  public function fetch($hashCode) {
    return $this->_pool->get($hashCode);
  }    
}
