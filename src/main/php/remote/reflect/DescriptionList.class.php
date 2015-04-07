<?php namespace remote\reflect;

/**
 * List of BeanDescription objects
 *
 * @see   xp://remote.reflect.BeanDescription
 */
class DescriptionList extends \lang\Object {
  public $beans= [];
    
  /**
   * Returns a list of all beans
   *
   * @return  remote.reflect.BeanDescription[]
   */
  public function beans() {
    return array_values($this->beans);
  }

  /**
   * Returns number of beans
   *
   * @return  int
   */
  public function size() {
    return sizeof($this->beans);
  }

  /**
   * Retrieve a single bean
   *
   * @param   string name
   * @return  remote.reflect.BeanDescription or NULL if nothing is found
   */
  public function bean($name) {
    return isset($this->beans[$name]) ? $this->beans[$name] : null;
  }
}
