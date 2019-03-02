Test Case ID: loft-deploy
Test Suite: WebPackage
Author: Aaron Klump
Created: March 1, 2019
---
## Test Scenario

Assert the version appears in Loft Deploy's overlay title.

## Pre-Conditions

1. Enable the loft_deploy module.
1. Enable the web_package module and install info file.

## Test Execution

1. Load a page showing Loft Deploy's overlay frame.
    - Assert the version appears in the title.
1. Change the version string in the info file
1. Refresh your browser.
    - Assert the version changes.
