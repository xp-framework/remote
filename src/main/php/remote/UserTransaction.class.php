<?php namespace remote;

/**
 * Remote transaction
 *
 * @see      xp://remote.Remote#begin
 * @purpose  Transaction
 */
class UserTransaction extends \lang\Object {
  public
    $_handler= null;

  /**
   * Commit this transaction
   *
   */
  public function commit() {
    $this->_handler->commit($this);
  }
  
  /**
   * Rollback this transaction
   *
   */
  public function rollback() {
    $this->_handler->rollback($this);
  }  
}
