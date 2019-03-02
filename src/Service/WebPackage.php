<?php

namespace Drupal\web_package\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Url;
use Symfony\Component\Yaml\Yaml;

/**
 * Main service class for web_package module.
 *
 * Provides the functionality of this module to Drupal.
 */
class WebPackage {

  /**
   * WebPackage constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   An instance of the config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Return the path to the package info file.
   *
   * @throws \RuntimeException
   *   If the info filepath doesn't exist as a file.
   */
  public function getInfoFilePath() {
    static $path = NULL;
    if (!isset($path)) {
      $path = $this->configFactory->get('web_package.settings')
        ->get('filepath');
      if (!($path = realpath($path))) {
        throw new \RuntimeException("Cannot locate info file \"$path\".");
      }
    }

    return $path;
  }

  /**
   * Parse the package info file.
   *
   * @param string $key
   *   A specific info key.
   *
   * @return mixed
   *   If key is not provided the entire array is returned.
   *   - file: will be the path to the info file if found.
   *   - installed bool If web package info file was located.
   *   - name
   *   - description
   *   - version
   */
  public function getInfo($key = NULL) {
    $info = &drupal_static(__FUNCTION__, []);
    if (empty($info)) {
      $info = [];
      try {
        $info['file'] = $this->getInfoFilePath();
        $info = $this->parseFile($info['file']);
        $info['installed'] = TRUE;
      }
      catch (\Exception $exception) {
        $info['file'] = NULL;
        $info['installed'] = FALSE;
      }
      $info += array_fill_keys(['name', 'description', 'version'], NULL);
    }
    if ($key === NULL) {
      return $info;
    }

    return array_key_exists($key, $info) ? $info[$key] : NULL;
  }

  /**
   * Detect file type and read it's contents into a data array.
   *
   * @param string $path
   *   Path to a file.
   *
   * @return array
   *   The parsed data from the file.
   *
   * @throws \InvalidArgumentException
   *   If $path does not exist, or is a type not understood.
   */
  protected function parseFile($path) {
    if (!file_exists($path)) {
      throw new \InvalidArgumentException("\"$path\" does not exist.");
    }
    switch (($ext = pathinfo($path, PATHINFO_EXTENSION))) {
      case 'yaml':
      case 'yml':
        $info = Yaml::parse(file_get_contents($path));
        break;

      case 'json':
        $info = json_decode($path, TRUE);
        break;

      case 'info':
        $info = parse_ini_file($path);
        break;

      default:
        throw new \InvalidArgumentException("Cannot understand info file of type \"$ext\".");
    }

    return $info;
  }

  /**
   * Return the current version.
   *
   * @return string
   *   The version string, ready for version_compare().
   */
  public function getVersion() {
    $default = $this->configFactory->get('web_package.settings')
      ->get('default_version');

    return (string) ($v = $this->getInfo('version')) ? $v : $default;
  }

  /**
   * Create an url that will bust browser cache based on package version.
   *
   * @param \Drupal\Core\Url $url
   *   An URL instance.  The query string will have vs={version} added to it.
   *   To change the key you need to modify your settings file.
   *
   * @return \Drupal\Core\Url
   *   $url with the cache buster added to the query string.
   *
   * @see web_package.settings.cache_buster
   */
  public function addCacheBusterToUrl(Url $url) {
    $key = $this->configFactory->get('web_package.settings')
      ->get('cache_buster');
    if (!($query = $url->getOption('query'))) {
      $query = [];
    }
    $query[$key] = $this->getVersion();
    $url->setOption('query', $query);

    return $url;
  }

}
