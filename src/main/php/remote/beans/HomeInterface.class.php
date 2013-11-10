<?php namespace remote\beans;



/**
 * Interface for all home interfaces
 *
 * @purpose  Home Interface
 */
interface HomeInterface extends BeanInterface {

  /**
   * Create method
   *
   * @return  remote.beans.Bean
   */
  public function create();
}
