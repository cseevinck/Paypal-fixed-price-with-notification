=== Plugin Name ===

Contributors:      Corky Seevinck
Plugin Name:       Paypal fixed price with notification
Tags:              paypal, fixed price, notification, IPN
Author URI:        http://www.chs-webs.com
Author:            Corky Seevinck
Tested up to:      5.6.1
Version:           1.0

== Description ==

This plugin allows sites to accept payments through Paypal. The prie of the item will be praced in a shortcode. The plugin requires that an IPN url is placed into the Paypal configuration for the receiving account. The note is placed in a pass through variable which is returned in the IPN. The plugin then builds an email to be sent to the specified receiving account.

Orginal plugin by Peter VanKoughnett. Too many changes to keep giving him credit as author.

== Installation ==

1. Install the plugin
1. Customize the plugin settings
1. Use the shortcode [ppfpn-paypal]price[/ppfpn-paypal] where you want the plugin to output

== Upgrade Notice ==

=1.0=
* First Version

== Screenshots ==
1. Screenshot of front end of plugin output
2. Screenshot of plugin admin interface

== Changelog ==

=1.0.0 =
* First version

== Frequently Asked Questions ==

=How do I customize the look of the plugin?=

I haven't built any tools to customize the look of the plugin yet.  You can disable the plugin CSS and write your own CSS.