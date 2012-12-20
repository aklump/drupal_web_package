SUMMARY:
Allows tracking of Drupal-base applications as a package. Adds a shell
script to automatically bump your version numbers and co a new hotfix or release
branch as appropriate.


ASSUMPTIONS/REQUIREMENTS:
* bump.sh requires that you are using git
* version string have to be this format: [major].[minor].[bugfix]
* You are using the gitflow method described here:

  http://nvie.com/posts/a-successful-git-branching-model



INSTALLATION:
* Download and unzip this module into your modules directory.
* Goto Administer > Site Building > Modules and enable this module.


CONFIGURATION:
* Install this module and a file will be created (if possible) in the web root,
  called package.info. If the web root is not writable by the server, then you
  will have to manually create this file. If you need to alter the name from
  package.info, then add the following line to your settings.php file:

  $conf['package_filepath'] = 'some_other_name.info';

* Once this file is created you need to manually edit it with the correct
  package information. A note on version schema. This module expects the
  following convention for package versioning: [major].[minor].[bugfix] e.g.
  1.2.34. (That final period is for the sentence not the version number.) The
  included scripts/bump.sh file expects this format.

* Open a new shell and type cat ~/.profile

* Find a line that begins:

  export PATH="...

* Make sure it contains the follwing. This tells bash where to look for the
  symlink you'll create below. If it does not then open that file, add the bit
  and then save it. Close the bash window and open a new one (to load the
  changes you just made).

  :~/bin:

* cd to the package/scripts directory and type: pwd

* copy the entire path you see printed.

* now, cd to ~/bin/ (or whatever directory is in your shell PATH and where you
  store executables, refer to above) and type the following, of course replacing
  the section in brackets with the path from the previous step. (You are
  creating an executable symlink for the bump.sh script)

  ln -s [insert copied path]/bump.sh bump

* To verify this is working, type:

  bump

  You should see something like, if not something is wrong.

  Package Version Bump
  --------------------
  Arg 1 is one of: major, minor, bug, hotfix, release
  Arg 2 is one of: hotfix, release



USAGE:
* To view package information from Drupal visit: admin/reports/status


HOTFIXES:
* Navigate to your web root and type:

  bump hotfix

* Now code the hotfix then merge back into your master/develop branches per
  standard gitflow.


NEW RELEASE (MINOR):
* Navigate to your web root and type:

  bump release

* Now do anything necessary for the release then merge back into your
  master/develop branches per standard gitflow.

NEW RELEASE (MAJOR):
* Navigate to your web root and type:

  bump major release

* Now do anything necessary for the release then merge back into your
  master/develop branches per standard gitflow.


--------------------------------------------------------
CONTACT:
In the Loft Studios
Aaron Klump - Web Developer
PO Box 29294 Bellingham, WA 98228-1294
aim: theloft101
skype: intheloftstudios

http://www.InTheLoftStudios.com
