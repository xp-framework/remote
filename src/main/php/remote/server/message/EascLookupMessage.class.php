<?php namespace remote\server\message;
 
use remote\server\naming\NamingDirectory;


/**
 * EASC lookup message
 *
 * @purpose  Lookup message
 */
class EascLookupMessage extends EascMessage {

  /**
   * Get type of message
   *
   * @return  int
   */
  public function getType() {
    return REMOTE_MSG_LOOKUP;
  }
  
  /**
   * Handle message
   *
   * @param   remote.server.EASCProtocol protocol
   * @return  var data
   */
  public function handle($protocol, $data) {
    $offset= 0;
    $name= $protocol->readString($data, $offset);

    $directory= NamingDirectory::getInstance();
    $this->setValue($directory->lookup($name));
  }
}
