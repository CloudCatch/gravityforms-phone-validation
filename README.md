# Gravity Forms Phone Validation #

This plugin uses the [libphonenumber for PHP](https://github.com/giggsey/libphonenumber-for-php) to validate Gravity Forms phone number fields against a given region specified through the plugin settings. This plugin was created to help mitigate form submissions that contain invalid / fake phone numbers.

## How to use

- Install and activate the plugin
- Navigate to the Gravity Forms settings page: `Forms > Settings`
- On this main settings page, towards the bottom is a field labeled **Phone Validation Region**, specify the region in which you want to validate phone numbers against, and save.

## Usage

This plugin by default will validate against **US** based phone numbers unless otherwise specified in the Gravity Forms settings.

Submitting any form containing a **Phone** field type will now validate the phone number against the region.