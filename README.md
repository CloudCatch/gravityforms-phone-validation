# Gravity Forms Phone Validation #

This plugin uses the [libphonenumber for PHP](https://github.com/giggsey/libphonenumber-for-php) to validate Gravity Forms phone number fields against a given region specified through the plugin settings. This plugin was created to help mitigate form submissions that contain invalid / fake phone numbers.

## Installation

```shell
composer require cloudcatch/gravityforms-phone-validation
```

You can manually install this plugin by cloning this repository, and installing the requires dependencies:

```shell
# Clone the repository
git clone https://github.com/CloudCatch/gravityforms-phone-validation.git

# Change directory
cd gravityforms-phone-validation

# Install dependencies
composer install --no-dev

# Optionally generate a plugin zip which will output in the ./dist directory
composer run plugin-zip
```

## How to use

- Install and activate the plugin
- Navigate to the Gravity Forms settings page: `Forms > Settings`
- On this main settings page, towards the bottom is a field labeled **Phone Validation Region**, specify the region in which you want to validate phone numbers against, and save.

![image](https://github.com/user-attachments/assets/c95dd81f-5308-4e10-9ae5-0731d0ac6ac7)

## Usage

This plugin by default will validate against **US** based phone numbers unless otherwise specified in the Gravity Forms settings.

Submitting any form containing a **Phone** field type will now validate the phone number against the region.

![image](https://github.com/user-attachments/assets/8daaa25c-ad41-4ec2-9825-5adcf8c3a5d3)
