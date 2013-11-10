<?php namespace remote\server\message;

use remote\protocol\XpProtocolConstants;
use lang\XPClass;

/**
 * Factory class for EASC message classes
 */
abstract class EascMessageFactory extends \lang\Object {
  protected static 
    $handlers= array();
  
  static function __static() {
    self::$handlers[XpProtocolConstants::INIT]= XPClass::forName('remote.server.message.EascInitMessage');
    self::$handlers[XpProtocolConstants::LOOKUP]= XPClass::forName('remote.server.message.EascLookupMessage');
    self::$handlers[XpProtocolConstants::CALL]= XPClass::forName('remote.server.message.EascCallMessage');
    self::$handlers[XpProtocolConstants::VALUE]= XPClass::forName('remote.server.message.EascValueMessage');
    self::$handlers[XpProtocolConstants::EXCEPTION]= XPClass::forName('remote.server.message.EascExceptionMessage');
  }

  /**
   * Set handler for a given type to 
   *
   * @param   int type
   * @param   lang.XPClass class
   */
  public static function setHandler($type, XPClass $class) {
    self::$handlers[$type]= $class;
  }

  /**
   * Factory method
   *
   * @param   int type
   * @return  remote.server.message.EascMessage
   * @throws  lang.IllegalArgumentException if no message exists for this type.
   */
  public static function forType($type) {
    if (!isset(self::$handlers[$type])) {
      throw new \lang\IllegalArgumentException('Unknown message type '.$type);
    }
    return self::$handlers[$type]->newInstance();
  }
}
