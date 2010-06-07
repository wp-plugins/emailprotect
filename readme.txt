=== EMAILProtect ===
Contributors: hallis
Donate link: http://amateurs-exchange.blogspot.com/
Tags: email, protect, emailprotect, spiders, crawlers, spam
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: 1.5

Protect e-mail addresses from being found by spam spiders (or any other crawlers).

== Description ==

EMAILProtect uses regular expression to locate, split and replace the e-mail string 
with a JavaScript function - which put the parts back together and print a clickable 
e-mailaddress.

Most crawlers thees days are "non-javascript crawlers" (to speed up the crawling process)
which means that almost no crawlers can see the e-mail address - even though it look just the same
for the regular user/client.

== Installation ==

The plugin works by it self. The files ('EMAILProtect.php' and 'EMAILProtect.js') should be
placed within a folder named 'emailprotect' - this is essential for the PHP file to locate the
JavaScript file.

1. Upload `EMAILProtect.php` and `EMAILProtect.js` to: `/wp-content/plugins/emailprotect/`
2. Activate the plugin through the 'Plugins' menu in Wordpress

By version 1.5 you're able to decide if you want to rewrite all the e-mail addresses or just the
once surrounded by a link tag. You do this by changing row *36* in the PHP-file to: *$allClickable = 0;*

== Changelog ==

= 1.5 =
* E-mail addresses surrounded by a link will be correctly rewritten.
* More accepted surrounding tags
* Possibility not to rewrite every tag is made
* Simple bugfix

= 1.4 =
* First stable version

== Upgrade Notice ==

= 1.5 =
* On line 36 in `EMAILProtect.php` there's a variable (*$allClickable*) which by default is set to *1*. If this would be changed to *0* only link tags (e.g. <a href="mailto:something@something.com">something@something.com</a>) will be rewritten to links, but regular e-mail strings will still be rewritten.
* For link tags to work with this version the link text must be the e-mail address.