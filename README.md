# Sargas reCAPTCHA

![Sargas reCAPTCHA Icon](https://ps.w.org/sargas-recaptcha/assets/icon-128x128.gif?rev=2856348)

[![WordPress Plugin](https://img.shields.io/wordpress/plugin/v/sargas-recaptcha.svg)](https://wordpress.org/plugins/sargas-recaptcha/)
[![License](https://img.shields.io/badge/license-GPLv2-blue.svg)](LICENSE)

Sargas reCAPTCHA is a simple and effective WordPress plugin to add Google reCAPTCHA to your website, enhancing your site's security by protecting it from spam and abuse.

## Description

Integrate Google reCAPTCHA on your website. Protect the Login, Registration, Lost Password, and Comments forms. The plugin also supports WooCommerce, Mailchimp for WordPress, Ninja Forms Contact Form, and Gravity Forms plugins.

## Features

- Add reCAPTCHA to:
    - Login form
    - Registration form
    - Lost Password form
    - Comments form
    - MailChimp for WordPress
    - WooCommerce:
        - Login form
        - Registration form
        - Lost password form
        - Checkout form
    - Ninja Forms Contact Form
    - Gravity Forms

## Installation

1. Follow the official [WordPress plugin installation manual](https://wordpress.org/support/article/managing-plugins/#installing-plugins-1).
2. Visit the [Google reCAPTCHA admin dashboard](https://www.google.com/recaptcha/admin/create) and generate API keys.
3. Fill in the required fields with the keys on the plugin settings page.

## Translation

- Ukrainian (uk)
- Russian (ru_RU)

## Frequently Asked Questions

### Why do I see a warning after changing the version of reCAPTCHA?

Since reCAPTCHA v2 and reCAPTCHA v3 require different API keys, using the wrong keys can cause the plugin to work incorrectly and block access to the WordPress dashboard.

### The plugin blocks access to the WordPress admin dashboard. What should I do?

1. Connect to your server via FTP (using any convenient FTP client, [FileZilla](https://filezilla-project.org/) for example).
2. Navigate to your site's root directory.
3. Navigate to the `/wp-content/plugins` directory.
4. Find and rename the `sargas-recaptcha` folder to something like `_sargas-recaptcha`.
5. The plugin is now deactivated, and you can access the dashboard.

## Screenshots

1. General settings page.
2. Standard forms settings page.
3. WooCommerce forms settings page.
4. Mailchimp for WordPress settings page.
5. Login form with reCAPTCHA v2.
6. Login form with reCAPTCHA v3.
7. Registration form with reCAPTCHA v2.
8. Registration form with reCAPTCHA v3.
9. Lost password form with reCAPTCHA v2.
10. Lost password form with reCAPTCHA v3.
11. Comment form with reCAPTCHA v2.
12. Comment form with reCAPTCHA v3.
13. WooCommerce login and registration with reCAPTCHA v2.
14. WooCommerce login and registration with reCAPTCHA v3.
15. WooCommerce lost password form with reCAPTCHA v2.
16. WooCommerce lost password form with reCAPTCHA v3.
17. WooCommerce checkout form with reCAPTCHA v2.
18. WooCommerce checkout form with reCAPTCHA v3.
19. Mailchimp for WordPress form with reCAPTCHA v2.
20. Mailchimp for WordPress form with reCAPTCHA v3.
21. reCAPTCHA v2 widget preview.
22. Message about successful reCAPTCHA v2 key verification.
23. reCAPTCHA v3 widget preview.
24. Message about successful reCAPTCHA v3 key verification.
25. Ninja Forms settings page.
26. Ninja Forms builder with Sargas reCAPTCHA custom field.
27. Contact Us form by Ninja Forms with reCAPTCHA v2.
28. Contact Us form by Ninja Forms with reCAPTCHA v3.
29. Gravity Forms settings page.
30. Contact form by Gravity Forms with reCAPTCHA v2.
31. Contact form by Gravity Forms with reCAPTCHA v3.

## Changelog

### 1.0.0
- Plugin release

### 1.0.1
- Bugfix: Fixed bug with plugin activation.

### 1.0.2
- Added support for Ninja Forms plugin.
- Added support for Gravity Forms plugin.
- Added reCAPTCHA widget preview and keys verification functionality.
- Added feature request form.
- Updated translations.

## Upgrade Notice

### 1.0.1
- Bugs fixed.

### 1.0.2
- Added plugin support for Ninja Forms and Gravity Forms. Added reCAPTCHA widget preview, as well as the ability to verify keys on the settings page. Added ability to give feedback or suggest new functionality. Updated .pot file for translators together with Ukrainian and Russian translations.

## License

This project is licensed under the GPLv2 License - see the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) file for details.

## Credits

Thanks to [Mehdi Soltani](https://wpwebmaster.ir/author/mehdi-soltani/) ([GitHub](https://github.com/msn60/oop-wordpress-plugin-boilerplate)) for the combined OOP and WordPress plugin concepts!

## Support

For any issues or feature requests, please open an issue on this repository or contact us via the support forum on [WordPress.org](https://wordpress.org/plugins/sargas-recaptcha/).

---

Made with ❤️ by Sargas Inc.
