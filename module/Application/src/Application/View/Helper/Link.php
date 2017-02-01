<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Uri\Http as HttpUri;

/**
 *
 */
class Link extends AbstractHelper
{

  protected $config;
  protected $src;
  protected $type = 'statics';
  protected $enabled = true;

  public function __construct()
  {
      return $this;
  }
  //invocamos a la funcion
  public function __invoke($src = null)
  {
      if (null === $src)
          return $this;
      
      $this->checkSessionHttps();
      $this->src = $src;
      return $this->cdn();
  }

  //Seteamos el tipo de cdn que se usara
  public function checkSessionHttps()
  {
    $session         = new \Zend\Session\Container('session_payment');
    $is_https_enable = isset($session->https_enable) ? $session->https_enable : false;
    if($is_https_enable) $this->setType('statics_https');
  }
  
  public function setType($type)
  {
    $this->type=$type;
  }


  public function setConfig(array $config)
  {
      if (empty($config)) {
          throw new InvalidArgumentException('La configuracion de CDN no deberia estar vacia');
      }
      $this->config = $config;
      $this->setupParams();
      return $this;
  }

  protected function setupParams()
  {
    if(!$this->config){
        throw new \Exception("No Existe Configuración", 500);
    }

    if(isset($this->config['link_helper']['enabled'])){
        $this->enabled = $this->config['link_helper']['enabled'];
    }

    static::$lastCommit = $this->getLastCommit();
  }

  /**
   * Get cdn link
   * @param string $src
   */
  public function cdn()
  {
      $this->checkCdn();
      return $this->processUrl();
  }

  /**
   *
   * @var string
   */
  protected static $lastCommit;

  protected function checkCdn()
  {
      if (!$this->enabled) {
          return $this->src;
      }

      if (!is_string($this->src)) {
          throw new InvalidArgumentException('La url debe ser un string');
      }

      if (!isset($this->config[$this->type])) {
          throw new \Exception("No se encuentra el key Mencionado",500);
      }

  }

  protected function processUrl()
  {
      $config = $this->config[$this->type];
      $uri = new HttpUri($this->src);
      if ($uri->getHost()) {
          return $uri->toString();
      }

      $uri->setScheme($config['scheme']);
      $uri->setPort($config['port']);
      $uri->setHost($config['host']);
      $uri->setQuery(static::$lastCommit);
      return $uri->toString();
  }

  /**
   * @todo upgrade codigo
   * @return string
   */
  public function getUrl()
  {
      $uri = new HttpUri();
      $config = $this->config[$this->type];
      $uri->setScheme($config->scheme);
      $uri->setPort($config->port);
      $uri->setHost($config->host);

      return $uri->toString();
  }

  public function getLastCommit()
  {
      $lc_file = ROOT_PATH . '/last_commit';
      if (is_readable($lc_file)) {
          if (!isset(static::$lastCommit)) {
              static::$lastCommit = trim(file_get_contents($lc_file));
          }
      }

      return static::$lastCommit;
  }
}
