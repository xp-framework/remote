<?php namespace remote\server\deploy;

use util\log\Logger;
use remote\server\container\StatelessSessionBeanContainer;
use remote\server\naming\NamingDirectory;
use remote\server\ContainerInvocationHandler;
use util\log\Traceable;


define('DEPLOY_LOOKUP_KEY',         'lookupName');
define('DEPLOY_PEERCLASS_KEY',      'peerClass');
define('DEPLOY_HOMEINTERFACE_KEY',  'homeInterface');

/**
 * Deployer
 *
 * @purpose  Deployer
 */
class Deployer extends \lang\Object implements Traceable {
  protected
    $cat      = null;

  /**
   * Deploy
   *
   * @param   remote.server.deploy.Deployable deployment
   */
  public function deployBean($deployment) {
    if ($deployment instanceof IncompleteDeployment) {
      throw new DeployException(
        'Incomplete deployment originating from '.$deployment->origin, 
        $deployment->cause
      );
    }

    $this->cat && $this->cat->info($this->getClassName(), 'Begin deployment of', $deployment);

    // Register beans classloader. This classloader must be put at the beginning
    // to prevent loading of the home interface not implmenenting BeanInterface
    $cl= $deployment->getClassLoader();
    \lang\ClassLoader::getDefault()->registerLoader($cl, true);

    $impl= $cl->loadClass($deployment->getImplementation());
    $interface= $cl->loadClass($deployment->getInterface());

    $directoryName= $deployment->getDirectoryName();

    // Fetch naming directory
    $directory= NamingDirectory::getInstance();

    // Create beanContainer
    // TBI: Check which kind of bean container has to be created
    $beanContainer= StatelessSessionBeanContainer::forClass($impl);
    $this->cat && $beanContainer->setTrace($this->cat);

    // Create invocation handler
    $invocationHandler= new ContainerInvocationHandler();
    $invocationHandler->setContainer($beanContainer);

    // Now bind into directory
    $directory->bind($directoryName, \lang\reflect\Proxy::newProxyInstance(
      $cl,
      array($interface),
      $invocationHandler
    ));
    
    $this->cat && $this->cat->info($this->getClassName(), 'End deployment of', $impl->getName(), 'with ND entry', $directoryName);

    return $beanContainer;
  }
  
  /**
   * Set a trace for debugging
   *
   * @param   util.log.LogCategory cat
   */
  public function setTrace($cat) { 
    $this->cat= $cat;
  }
} 
