<?php namespace remote\server\message;

/**
 * EASC server base message
 *
 * @purpose  EASC message
 */
abstract class EascMessage extends \lang\Object {
  public
    $value  = null;
  
  /**
   * Get type of message
   *
   * @return  int
   */
  public abstract function getType();    

  /**
   * Set Value
   *
   * @param   lang.Object value
   */
  public function setValue($value) {
    $this->value= $value;
  }

  /**
   * Get Value
   *
   * @return  lang.Object
   */
  public function getValue() {
    return $this->value;
  }
  
  /**
   * Handle message
   *
   * @param   remote.server.EASCProtocol protocol
   * @return  var data
   */
  public function handle($protocol, $data) { }
}
