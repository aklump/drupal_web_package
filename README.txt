SUMMARY:
Defines a framework for tracking Drupal projects as a single package.
Supports name, description and version string (major.minor.micro). Provides UI
elements native to Drupal for viewing this information.

This is loosely related to web_package (https://github.com/aklump/web_package) a
shell script to automatically bump your version numbers, create hotfix and
release branches and automatically tag releases, in that this module is able to
read the tracking data created by web_package.sh.


ASSUMPTIONS/REQUIREMENTS:
* version string needs to follow this format: [major].[minor].[micro]
* You are using the gitflow method described here:

  http://nvie.com/posts/a-successful-git-branching-model

* 0.0.x = alpha release
* 0.1.x = beta release
* 0.2.x = release candidate


INSTALLATION:
* Download and install web_package from https://github.com/aklump/web_package;
  follow the README.txt file therein. This is the shell script component of this
  module. It is not necessary, but highly recommended.
* Download and unzip this module into your modules directory.
* Goto Administer > Site Building > Modules and enable this module.


CONFIGURATION:
* When installing this module a file will be created (if possible) in the web
  root, called web_package.info. If the web root is not writable by the server,
  then you will have to manually create this file (you can follow the steps in
  the web_package shell script if you want).

* If for some reason you're package information is not located in
  web_package.info, you should set the following line to your settings.php file.
  YOU SHOULD DO THIS BEFORE INSTALLING SINCE THE MODULE WILL TRY TO CREATE YOUR
  PACKAGE FILE:

  $conf['web_package_filepath'] = DRUPAL_ROOT . '/../some_other_name_above_web_root.info';

* Once this file is created you need to manually edit it with the correct
  package information. A note on version schema. This module expects the
  following convention for package versioning: [major].[minor].[micro] e.g.
  1.2.34. (That final period is for the sentence not the version number.)

* Note that when 1.2.9 increments, it goes to 1.2.10, NOT 1.3.0; each portion of
  the version can increment to as high a number as needed.


TROUBLESHOOTING:
* Make sure to wrap your name and description in double quotes to prevent parse
  errors when reading your package information.

This is wrong and will probably break the status page:
@code
name = My Module (Not Yours)
description = It's really cool
@endcode

This is correct (has double quotes around values)
@code
name = "My Module (Not Yours)"
description = "It's really cool"
@endcode


USAGE:
* To view package information from Drupal visit: admin/reports/status
* Read about using web_package.sh in the files contained with that package


CACHE BUSTING:
* You can use this module to generate cache-busting urls based on the package
  version. See web_package_cache_buster_url() for more info.

--------------------------------------------------------
CONTACT:
In the Loft Studios
Aaron Klump - Web Developer
PO Box 29294 Bellingham, WA 98228-1294
aim: theloft101
skype: intheloftstudios

http://www.InTheLoftStudios.com
