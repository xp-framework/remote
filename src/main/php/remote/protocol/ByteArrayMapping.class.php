<?php namespace remote\protocol;

use lang\types\Bytes;


/**
 * Mapping for lang.types.Bytes
 *
 * @see      xp://remote.protocol.Serializer
 * @purpose  Mapping
 */
class ByteArrayMapping extends \lang\Object implements SerializerMapping {

  /**
   * Returns a value for the given serialized string
   *
   * @param   server.protocol.Serializer serializer
   * @param   remote.protocol.SerializedData serialized
   * @param   [:var] context default array()
   * @return  var
   */
  public function valueOf($serializer, $serialized, $context= array()) {
    return new Bytes($serialized->consumeString());
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
    return 'Y:'.$value->size.':"'.$value->buffer.'";';
  }
  
  /**
   * Return XPClass object of class supported by this mapping
   *
   * @return  lang.XPClass
   */
  public function handledClass() {
    return \lang\XPClass::forName('lang.types.Bytes');
  }
} 
