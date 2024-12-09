# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

- Nothing to list

## [1.7.1] - 2024-12-09

### Added

- Example images to the README

### Removed

- The function `web_package_loft_deploy_title_pre_alter`. Here is the code so you can implement in your own module if desired.

    ```php
    /**
     * Implements hook_loft_deploy_title_pre_alter().
     *
     * Add the version to the title.
     */
    function MY_MODULE_loft_deploy_title_pre_alter(&$title) {
      $version = Drupal::service('web_package')->getVersion();
      $title .= t(' ~ @version', ['@version' => $version]);
    }
    ```

## [1.7.0] - 2024-06-10

### Added

- `\Drupal\web_package\Service\WebPackage::getName`
- `\Drupal\web_package\Service\WebPackage::getDescription`

### Deprecated

- `\Drupal\web_package\Service\WebPackage::getInfo`

## [8.x-1.6-rc1]

* The info file will no longer be created automatically.
