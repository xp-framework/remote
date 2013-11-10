<?php namespace remote;

/**
 * Holds a reference to a class
 *
 * @see      xp://remote.Serializer
 * @purpose  Class reference
 */
class ClassReference extends \lang\Object {
  public 
    $classname = '';

  /**
   * Constructor
   *
   * @param   string classname
   */
  public function __construct($classname) {
    $this->classname= $classname;
  }

  /**
   * Retrieved referenced class name
   *
   * @return  string
   */
  public function referencedName() {
    return $this->classname;
  }

  /**
   * Retrieved referenced class name
   *
   * @param   lang.ClassLoader cl default NULL
   * @return  lang.XPClass
   */
  public function referencedClass($cl= null) {
    return \lang\XPClass::forName($this->classname, $cl);
  }

  /**
   * Returns the hash code for this object
   *
   * @return  string
   */
  public function hashCode() {
    return md5($this->classname);
  }
}
