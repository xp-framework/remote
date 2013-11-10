<?php namespace remote;

/**
 * Entry class for all remote operations
 *
 * Example:
 * <code>
 *   try {
 *     $remote= Remote::forName('xp://localhost:6448/');
 *     $calculator= $remote->lookup($jndiName);
 *   } catch (RemoteException $e) {
 *     $e->printStackTrace();
 *     exit(-1);
 *   }
 *   
 *   Console::writeLine('1 + 1 = ', xp::stringOf($calculator->add(1, 1)));
 *   Console::writeLine('1 - 1 = ', xp::stringOf($calculator->subtract(1, 1)));
 * </code>
 *
 * To use clustering and fail-over, supply a comma-separated list of
 * remote names as follows:
 * <code>
 *   $remote= Remote::forName('xp://remote1,xp://remote2');
 * </code>
 * 
 * @test     xp://net.xp_framework.unittest.remote.RemoteTest
 * @see      xp://remote.HandlerFactory
 */
class Remote extends \lang\Object {
  public $_handler= null;

  /**
   * Returns a string representation of this object
   *
   * @return  string
   */
  public function toString() {
    return $this->getClassName().'(handler= '.$this->_handler->toString().')';
  }
  
  /**
   * Retrieve remote instance for a given DSN. Invoking this method
   * twice with the same dsn will result in the same instance.
   *
   * @param   string dsn
   * @return  remote.Remote
   * @throws  remote.RemoteException in case of setup failure
   */
  public static function forName($dsn) {
    static $instances= array();
    
    $pool= HandlerInstancePool::getInstance();
    $list= explode(',', $dsn);
    shuffle($list);
    foreach ($list as $key) {
      $key= trim($key);
      if (isset($instances[$key])) return $instances[$key];

      // No instance yet, so get it
      $e= $instance= null;
      try {
        $instance= new self();
        $instance->_handler= $pool->acquire($key, true);
      } catch (RemoteException $e) {
        continue;   // try next
      } catch (\lang\XPException $e) {
        $e= new RemoteException($e->getMessage(), $e);
        continue;   // try next
      }

      // Success, cache instance and return
      $instances[$key]= $instance;
      return $instance;
    }

    // No more active hosts
    throw $e;
  }

  /**
   * Map a remote package name to a local package
   *
   * @param   string remote
   * @param   lang.reflect.Package mapped
   */
  public function mapPackage($remote, \lang\reflect\Package $mapped) {
    $this->_handler->serializer->mapPackage($remote, $mapped);
  }
  
  /**
   * Look up an object by its name
   *
   * @param   string name
   * @return  lang.Object
   * @throws  remote.NameNotFoundException in case the given name could not be found
   * @throws  remote.RemoteException for any other error
   */
  public function lookup($name) {
    return $this->_handler->lookup($name);
  }

  /**
   * Begin a transaction
   *
   * @param   remote.UserTransaction tran
   * @return  remote.UserTransaction
   */
  public function begin($tran) {
    $this->_handler->begin($tran);
    $tran->_handler= $this->_handler;
    return $tran;
  }
}
