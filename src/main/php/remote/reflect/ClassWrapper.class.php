<?php namespace remote\reflect;

use util\collections\HashSet;


/**
 * Describes a class 
 *
 * @see      xp://remote.Remote
 * @purpose  Reflection
 */
class ClassWrapper extends \lang\Object {
  public 
    $className   = '',
    $fields      = array(); 

  /**
   * Retrieve a set of classes used in this interface
   *
   * @return  remote.ClassReference[]
   */
  public function classSet() {
    $set= new HashSet();
    foreach (array_keys($this->fields) as $name) {
      if (!$this->fields[$name] instanceof \remote\ClassReference) continue;
      
      $set->add($this->fields[$name]);
    }
    return $set->toArray();
  }

  /**
   * Get ClassName
   *
   * @return  string
   */
  public function getName() {
    return $this->className;
  }

  /**
   * Creates a string representation of this object
   *
   * @return  string
   */
  public function toString() {
    $fields= '';
    foreach (array_keys($this->fields) as $name) {
      $fields.= sprintf("  [%-20s] %s\n", $name, \xp::stringOf($this->fields[$name]));
    }
    return sprintf(
      "%s@(name= %s) {\n%s}",
      $this->getClassName(),
      $this->className,
      $fields
    );
  }
}
