<?php namespace remote\protocol;

use util\Hashmap;


/**
 * Mapping for Hashmaps
 *
 * @see      xp://remote.protocol.Serializer
 * @purpose  Mapping
 */
class HashmapMapping extends \lang\Object implements SerializerMapping {

  /**
   * Returns a value for the given serialized string
   *
   * @param   server.protocol.Serializer serializer
   * @param   remote.protocol.SerializedData serialized
   * @param   [:var] context default array()
   * @return  var
   */
  public function valueOf($serializer, $serialized, $context= array()) {
    // No implementation
  }

  /**
   * Returns an on-the-wire representation of the given value
   *
   * @param   server.protocol.Serializer serializer
   * @param   lang.Object value
   * @param   [:var] context default array()
   * @return  string
   */
  public function representationOf($serializer, $value, $context= array()) {
    return $serializer->representationOf($value->_hash, $context);
  }
  
  /**
   * Return XPClass object of class supported by this mapping
   *
   * @return  lang.XPClass
   */
  public function handledClass() {
    return \lang\XPClass::forName('util.Hashmap');
  }
} 
