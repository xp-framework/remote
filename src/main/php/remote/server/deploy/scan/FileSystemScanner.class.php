<?php namespace remote\server\deploy\scan;

use lang\archive\Archive;
use io\File;
use io\Folder;
use util\Properties;
use remote\server\deploy\IncompleteDeployment;

/**
 * Deployment scanner that as
 *
 * @purpose  Interface
 */
class FileSystemScanner extends \lang\Object implements DeploymentScanner {
  public
    $folder   = null,
    $pattern  = '',
    $files    = array(),
    $deployments= array();
    
    
  /**
   * Constructor
   *
   * @param   string dir
   * @param   string pattern default ".xar$"
   */
  public function __construct($dir, $pattern= '.xar$') {
    $this->folder= new Folder($dir);
    $this->pattern= '/'.$pattern.'/';
  }

  /**
   * Get a list of deployments
   *
   * @return  remote.server.deploy.Deployable[]
   */
  public function scanDeployments() {
    clearstatcache();
    $this->changed= false;

    while ($entry= $this->folder->getEntry()) {
      if (!preg_match($this->pattern, $entry)) continue;
      
      $f= new File($this->folder->getURI().$entry);
      
      if (isset($this->files[$entry]) && $f->lastModified() <= $this->files[$entry]) {
      
        // File already deployed
        continue;
      }
      
      $this->changed= true;

      $ear= new Archive(new File($this->folder->getURI().$entry));
      try {
        $ear->open(ARCHIVE_READ) &&
        $meta= $ear->extract('META-INF/bean.properties');
      } catch (\lang\Throwable $e) {
        $this->deployments[$entry]= new IncompleteDeployment($entry, $e);
        continue;
      }
      
      $prop= Properties::fromString($meta);
      $beanclass= $prop->readString('bean', 'class');
      
      if (!$beanclass) {
        $this->deployments[$entry]= new IncompleteDeployment($entry, new \lang\FormatException('bean.class property missing!'));
        continue;
      }

      $d= new \remote\server\deploy\Deployment($entry);
      $d->setClassLoader(new \lang\archive\ArchiveClassLoader($ear));
      $d->setImplementation($beanclass);
      $d->setInterface($prop->readString('bean', 'remote'));
      $d->setDirectoryName($prop->readString('bean', 'lookup'));
      
      $this->deployments[$entry]= $d; 
      $this->files[$entry]= time();

      unset($f);
    }
    
    // Check existing deployments
    foreach (array_keys($this->deployments) as $entry) {
      
      $f= new File($this->folder->getURI().$entry);
      if (!$f->exists()) {
        unset($this->deployments[$entry], $this->files[$entry]);
        
        $this->changed= true;
      }

      unset($f);
    }

    $this->folder->close();
    return $this->changed;
  }
  
  /**
   * Get deployments
   *
   * @return  var[] deployments
   */
  public function getDeployments() {
    return $this->deployments;
  }
  
  /**
   * Creates a string representation of this object
   *
   * @return  string
   */
  public function toString() {
    return $this->getClassName().'(pattern= '.$this->pattern.') {'.$this->folder->toString().'}';
  }

} 
