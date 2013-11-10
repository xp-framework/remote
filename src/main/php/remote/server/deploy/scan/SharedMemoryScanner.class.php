<?php namespace remote\server\deploy\scan;

use remote\server\deploy\Deployment;
use io\sys\ShmSegment;


/**
 * Deployment scanner
 *
 * @purpose  Interface
 */
class SharedMemoryScanner extends \lang\Object implements DeploymentScanner {

  /**
   * Constructor
   *
   */
  public function __construct() {
    $this->storage= new ShmSegment(0x3c872747);
  }

  /**
   * Scan if deployments changed
   *
   * @return  bool 
   */
  public function scanDeployments() {
    if ($this->storage->isEmpty()) return false;
    return true;
  }

  /**
   * Get a list of deployments
   *
   * @return  remote.server.deploy.Deployable[]
   */
  public function getDeployments() {
    return $this->storage->get();
  }
} 
