<?php namespace remote;

/**
 * Holds a reference to an exception
 *
 * @see      xp://remote.Serializer
 * @purpose  Exception reference
 */
class ExceptionReference extends \lang\XPException {
  public 
    $referencedClassname= '';

  /**
   * Constructor
   *
   * @param   string classname
   */
  public function __construct($classname) {
    parent::__construct('(null)', $cause= null);
    $this->referencedClassname= $classname;
  }
  
  /**
   * Return compound message of this exception.
   *
   * @return  string
   */
  public function compoundMessage() {
    return sprintf(
      'Exception %s<%s> (%s)',
      $this->getClassName(),
      $this->referencedClassname,
      $this->message
    );
  }
}
