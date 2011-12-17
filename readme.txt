=== WP Admin Block ===
Contributors: justingreerbbi, Blackbird Interactive
Donate link: http://blackbirdi.com/
Tags: Auth, admin, admin block, authinication
Requires at least: 3.0
Tested up to: 3.3.0
Stable tag: 1.3

WP Block Admin is a simple plugin that allows you to restrict access to the defualt Wordpress admin panel. WP Admin Block has been updated to work with Multisite enabled and or disabled.

== Description ==

Wp Block Admin allows you to enter a user defined key (set in the plugin options) that be used to enter the wp-login page. Any attempts to get to access the login screen without the secret key will result in the user being redirected back to the root url. If the user does manage to get the login screen and login, they will be redirect back to the root url aswell. Only user ID of 1 is able to be in the admin panel.


This plugin is very new and and we are sure tat there is some bugs and wanted features. To report a bug or request a feature please visit http://blog.blackbirdi.com and leave a comment.

You are free to modify this plugin how ever need be.

== Installation ==

1. Upload `wp-admin-block` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Once the plugin is active go to Tool->WP Block and enter a secret key then click "Save Changes" 

== Frequently Asked Questions ==

= Does this support multiple users? =

Currently the plugin ONLY supports 1 user being able to login to the wp-admin panel

= I activated the plugin but did not provide a key and I logged out. How do I get in? =

Wp-Bock as a fall back default key to get in if no key was provided yet. Use the key `1111` and if you are able to get to the login screen but not get redirected to the root, then make sure you are using the Super Admin account for the blog. (USER ID MUST BE 1).

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the directory of the stable readme.txt, so in this case, `/tags/4.3/screenshot-1.png` (or jpg, jpeg, gif)
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Intial Build

= 1.1 =
* Minor Bug Fixes

= 1.2 =
* Minor Bug Fixes
* Typo Fix

= 1.3 =
* Major bug fixed that crashed wordpress that did not have Multisite enabled.


