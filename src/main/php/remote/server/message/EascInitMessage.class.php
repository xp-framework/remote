<?php namespace remote\server\message;



/**
 * EASC Init message
 *
 * @purpose  Init message
 */
class EascInitMessage extends EascMessage {

  /**
   * Get type of message
   *
   * @return  int
   */
  public function getType() {
    return REMOTE_MSG_INIT;
  }

  /**
   * Handle message
   *
   * @param   remote.server.EASCProtocol protocol
   * @return  var data
   */
  public function handle($protocol, $data) {
    $this->setValue($b= true);
  }
}
