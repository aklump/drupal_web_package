                                  Web Package

Summary

   Provides a framework for reading project data, namely your project's
   version, into Drupal. For example you may use composer.json as the
   source of your information; or you can use a standalone YAML file. In
   all cases it is important that your data file provides the following
   keys, at least: version, title, description. The data is exposed to
   developer's through a new service interface. This is a very simple,
   lightweight module, with a real sense of purpose.

Features

     * Enhances the [1]Status report by displaying the project info
       (title, description, version) above the core version info.
     * Enhances Loft Deploy module by adding the project version to the
       displayed title.
     * Enhances admin_menu by displaying the version in the top bar.

Quick Start

    1. Create one of the following files types (.yml, .info, .json, .ini)
       somewhere in your codebase. This example will place a yaml file one
       directory above web root, called web_package.yml. You can use a
       composer.json file if you want, as long as you place a version key
       in the root level of the file.
    2. Add the following as the contents of that file. Other keys are
       supported and you may add whatever you wish.
title: My Project
description: A cool project indeed
version: 1.0.0

    3. Identify your data file in settings.php or settings.local.php like
       this:
$config['web_package.settings']['filepath'] = DRUPAL_ROOT . '/../web_package.yml
';

    4. Now, enable this module and visit the [2]Status report.
    5. You should see the information on that page, you may have to scroll
       down.
    6. Now set up some means beyond this module, to increment the version
       string in web_package.yml as appropriate to your development/build
       process.

Contributing

   If you find this project useful... please consider [3]making a
   donation.

Developers

   Unless you set up some means of updating the version string as your
   project goes through it's build process, this module is not very
   helpful. So you will need to make arrangements to do that.

  API

   Developers may use the following in their custom code.
\Drupal::service('web_package')->getVersion();
\Drupal::service('web_package')->getInfo();
\Drupal::service('web_package')->createCacheBusterUrl();
\Drupal::service('web_package')->getInfoFilePath();

  Cache Busting

   This module provides a service method to add cache busters to URLs,
   e.g. ?vs=8.x-1.0, see the example below for usage.
$url = Url::fromRoute('system.status');
$url = \Drupal::service('web_package')
  ->addCacheBusterToUrl($url)
  ->toString();
// $url === '/admin/reports/status?vs=8.x-1.0'

   The query string var can be customized in settings.php using:
$config['web_package.settings']['cache_buster'] = 'cb';

  A Tool To Manage Versions

     * Read about a tool by the author of this module, [4]web_package.sh,
       which handles version incrementing. This project stems from that
       one, but doesn't require it.

Module Roadmap

Upgrade Path Drupal 7 to 8

     * Replace all instances of web_package_filepath with
       \Drupal::service('web_package')->getInfoFilepath()
     * Replace all instances of web_package_info with
       \Drupal::service('web_package')->getInfo()
     * Replace all instances of web_package_get_version with
       \Drupal::service('web_package')->getVersion()
     * Replace all instances of web_package_cache_buster_url with
       \Drupal::service('web_package')->createCacheBusterUrl()
     * In settings file change $conf['web_package_filepath'] = DRUPAL_ROOT
       . '/../web_package.info'; to
       $config['web_package.settings']['filepath'] = DRUPAL_ROOT .
       '/../web_package.info'
     * Optionally, convert web_package.info to YAML or JSON, if desired.

References

   1. file:///admin/reports/status
   2. file:///admin/reports/status
   3. https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4E5KZHDQCEUV8&item_name=Gratitude%20for%20aklump%2Fweb_package
   4. https://github.com/aklump/web_package
