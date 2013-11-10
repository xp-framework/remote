<?php namespace remote\beans;

/**
 * Interface for all home interfaces
 */
interface HomeInterface extends BeanInterface {

  /**
   * Create method
   *
   * @return  remote.beans.Bean
   */
  public function create();
}
