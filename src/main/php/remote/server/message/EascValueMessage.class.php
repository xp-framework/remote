<?php namespace remote\server\message;



/**
 * EASC value message
 *
 * @purpose  Value message
 */
class EascValueMessage extends EascMessage {

  /**
   * Get type of message
   *
   * @return  int
   */
  public function getType() {
    return REMOTE_MSG_VALUE;
  }
}
