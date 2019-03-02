Test Case ID: status
Test Suite: WebPackage
Author: Aaron Klump
Created: March 1, 2019
---
## Test Scenario

The status page displays correctly based on state of info file.

## Pre-Conditions

1. Enable the web_package module.
1. Enable the toolbar module.
1. Create a valid info file.
1. Add the filepath to the settings file.

## Test Execution
1. Look at the toolbar at the top of the page.
    - Assert the toolbar shows the version in the far right of the toolbar.
1. Click the toolbar link.    
    - Assert you are taken to the status page.
    - Assert you see the title, version and description in the _Checked_ area of the status page.    
1. Comment out the filepath in your settings file.
1. Reload the [Status report](/admin/reports/status)
    - Assert you see and Error for _Web Package_ telling you to add the filepath to settings.
1. Uncomment the filepath in your settings file.
1. Remove the version declaration from your info file.
1. Reload the [Status report](/admin/reports/status)
    - Assert you see and Error for _Web Package_ telling you to the version is missing.
1. Add the version string back.

