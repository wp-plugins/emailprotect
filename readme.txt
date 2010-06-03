=== EMAILProtect ===
Contributors: hallis, deadmau5
Donate link: http://amateurs-exchange.blogspot.com/
Tags: email, spiders, crawlers, protect
Requires at least: 2.9.2
Tested up to: 2.9.2
Stable tag: 1.4

It protects e-mail addresses from beeing found by spam spiders (or any crawlers).

== Description ==

EMAILProtect uses regular expressions to find e-mail addresses and pick the it apart and let
JavaScript put the parts together again. This make's it (allmost) impossible for crawlers to
locate the e-mailaddresses.

== Installation ==

The plugin works by it self. The files (`EMAILProtect.php` and `EMAILProtect.js`) should be
placed within a folder named `emailprotect` - this is essential for the PHP file to locate the
JavaScript file.

1. Upload `EMAILProtect.php` and `EMAILProtect.js` to `/wp-content/plugins/emailprotect/`
2. Activate the plugin through the 'Plugins' menu in Wordpress

== Changelog ==

= 1.4 =
* First stable version

== A brief Markdown Example ==

* Rewrite e-mail strings to JavaScript
* Removes the possibility for non-js crawlers to locate e-mail addresses