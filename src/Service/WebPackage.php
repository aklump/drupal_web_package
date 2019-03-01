<?php

namespace Drupal\web_package\Service;

use Symfony\Component\Yaml\Yaml;

/**
 * Main service class for web_package module.
 *
 * Provides the functionality of this module to Drupal.
 */
class WebPackage {

  /**
   * Return the path to the package info file.
   */
  public function getInfoFilePath() {
    static $path = NULL;
    if (!isset($path)) {
      $path = \Drupal::config('web_package.settings')
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
   */
  public function getInfo($key = NULL) {
    $info = &drupal_static(__FUNCTION__, []);
    if (empty($info)) {
      $info = [];
      if (($file = $this->getInfoFilePath())
        && file_exists($file)
        && ($info = $this->parseFile($file))) {
        $info += [
          'name' => 'Web Package',
          'description' => 'Lorem ipsum dolar',
          'version' => '0.0.1',
        ];
      }
      $info['file'] = empty($file) ? NULL : $file;
      $info['installed'] = !empty($file);
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
        $info = Yaml::parse($path);
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
    $default = \Drupal::config('web_package.settings')
      ->get('default_version');

    return (string) ($v = $this->getInfo('version')) ? $v : $default;
  }

  /**
   * Create an url that will bust browser cache based on package version.
   *
   * @param string $path
   * @param array $options
   * @param string $key
   *   (Optional) Defaults to 'vs'. If this conflicts with your query than you
   *   may set the key with this param.
   *
   * @return
   *  A string containing a URL to the given path.
   *
   * @see url()
   */
  public function createCacheBusterUrl($path = NULL, $options = [], $key = 'vs') {
    $options['query'][$key] = $this->getVersion();

    // @FIXME
    // url() expects a route name or an external URI.
    // return url($path, $options);
  }

}
