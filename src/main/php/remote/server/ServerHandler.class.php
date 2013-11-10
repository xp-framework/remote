<?php namespace remote\server;

use remote\protocol\XpProtocolConstants;
use remote\server\message\EascMessageFactory;
use lang\reflect\Proxy;

/**
 * Server handler
 *
 * @purpose  handler
 */
class ServerHandler extends \lang\Object {
    
  /**
   * Set serializer
   *
   * @param   remote.protocol.Serializer serializer
   */
  public function setSerializer($serializer) {
    $this->serializer= $serializer;
  }  

  /**
   * Handle incoming data
   *
   * @param   peer.Socket socket
   * @param   peer.server.ServerProtocol protocol
   * @param   int type
   * @param   string data
   */
  public function handle($socket, $protocol, $type, $data) {
    try {
      $handler= EascMessageFactory::forType($type);
      $handler->handle($protocol, $data);

      $response= EascMessageFactory::forType(REMOTE_MSG_VALUE);
      $response->setValue($handler->getValue());

    } catch (\lang\Throwable $e) {
      $response= EascMessageFactory::forType(REMOTE_MSG_EXCEPTION);
      $response->setValue($e);
    }

    $protocol->answerWithMessage($socket, $response);
  }
}
