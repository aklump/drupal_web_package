<?php

/**
 * @file
 * Generates documentation, adjusts paths and adds to SCM.
 */

namespace AKlump\WebPackage;

$build
  ->generateDocumentation()
  // This will adjust the path to the image, pulling it from docs.
  ->loadFile('README.md')
  ->replaceTokens([
    'images/web-package.jpg' => 'docs/images/web-package.jpg',
  ])
  ->saveReplacingSourceFile()
  // Add some additional files to SCM that were generated and outside of the docs directory.
  ->addFilesToScm([
    'README.md',
    'CHANGELOG.md',
  ])
  ->displayMessages();
