# Web Package

## Summary

Provides a framework for reading project data, namely your project's _version_, into Drupal.  For example you may use _composer.json_ as the source of your information; or you can use a standalone YAML file.  In all cases it is important that your data file provides the following keys, at least: version, title, description.  The data is exposed to developer's through a new service interface.  This is a very simple, lightweight module, with a real sense of purpose.

## Features

* Enhances the [Status report](/admin/reports/status) by displaying the project info (title, description, version) above the core version info.
* Enhances _Loft Deploy_ module by adding the project version to the displayed title.
* Enhances _admin_menu_ by displaying the version in the top bar.

## Quick Start

1. Create one of the following files types (`.yml, .info, .json, .ini`) somewhere in your codebase.  This example will place a yaml file one directory above web root, called _web_package.yml_.  You can use a _composer.json_ file if you want, as long as you place a `version` key in the root level of the file.
1. Add the following as the contents of that file.  Other keys are supported and you may add whatever you wish.

        title: My Project
        description: A cool project indeed
        version: 1.0.0
        
1. Identify your data file in _settings.php_ or _settings.local.php_ like this:

        $config['web_package.settings']['filepath'] = DRUPAL_ROOT . '/../web_package.yml';
                
1. Now, enable this module and visit the [Status report](/admin/reports/status).
1. You should see the information on that page, you may have to scroll down.
1. Now set up some means beyond this module, to increment the version string in _web_package.yml_ as appropriate to your development/build process.

## Contributing

If you find this project useful... please consider [making a donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4E5KZHDQCEUV8&item_name=Gratitude%20for%20aklump%2Fweb_package).

## Developers

Unless you set up some means of updating the version string as your project goes through it's build process, this module is not very helpful.  So you will need to make arrangements to do that.

### API

Developers may use the following in their custom code.

    \Drupal::service('web_package')->getVersion();
    \Drupal::service('web_package')->getInfo();
    \Drupal::service('web_package')->createCacheBusterUrl();
    \Drupal::service('web_package')->getInfoFilePath();

### Cache Busting

This module provides a service method to add cache busters to URLs, e.g. `?vs=8.x-1.0`, see the example below for usage.

    $url = Url::fromRoute('system.status');
    $url = \Drupal::service('web_package')
      ->addCacheBusterToUrl($url)
      ->toString();
    // $url === '/admin/reports/status?vs=8.x-1.0'
    
The query string var can be customized in _settings.php_ using:

    $config['web_package.settings']['cache_buster'] = 'cb';    

### A Tool To Manage Versions

* Read about a tool by the author of this module, [web_package.sh](https://github.com/aklump/web_package), which handles version incrementing.  This project stems from that one, but doesn't require it.

## Module Roadmap

- [ ] roadmap: Improve the placement of the info on the [Status report](/admin/reports/status).

## Upgrade Path Drupal 7 to 8

* Replace all instances of `web_package_filepath` with `\Drupal::service('web_package')->getInfoFilepath()`
* Replace all instances of `web_package_info` with `\Drupal::service('web_package')->getInfo()`
* Replace all instances of `web_package_get_version` with `\Drupal::service('web_package')->getVersion()`
* Replace all instances of `web_package_cache_buster_url` with `\Drupal::service('web_package')->createCacheBusterUrl()`
* In _settings_ file change `$conf['web_package_filepath'] = DRUPAL_ROOT . '/../web_package.info';` to `$config['web_package.settings']['filepath'] = DRUPAL_ROOT . '/../web_package.info'`
* Optionally, convert _web_package.info_ to YAML or JSON, if desired.
