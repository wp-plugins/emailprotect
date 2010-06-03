=== EMAILProtect ===
Contributors: hallis, deadmau5
Donate link: http://amateurs-exchange.blogspot.com/
Tags: email, spiders, crawlers, protect
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: 1.4

Protect e-mail addresses from being found by spam spiders (or any other crawlers).

== Description ==

EMAILProtect use regular expressions to locate and split the e-mail address, replaces the
e-mail string with an JavaScript function which put the parts back together and print
an clickable e-mailaddress.

Most crawlers thees days are "non-javascript crawlers" (to speed up the crawling process)
which means that almost no crawlers se the e-mail address - even though it look just the same
for the normal client.

== Installation ==

The plugin works by it self. The files ('EMAILProtect.php' and 'EMAILProtect.js') should be
placed within a folder named 'emailprotect' - this is essential for the PHP file to locate the
JavaScript file.

1. Upload `EMAILProtect.php` and `EMAILProtect.js` to:
`/wp-content/plugins/emailprotect/`
2. Activate the plugin through the 'Plugins' menu in Wordpress

== Changelog ==

= 1.4 =
* First stable version