=== EMAILProtect ===
Contributors: hallis
Donate link: http://amateurs-exchange.blogspot.com/
Tags: email, protect, emailprotect, spiders, crawlers, spam
Requires at least: 2.8.5
Tested up to: 2.9.2
Stable tag: 1.5.4

Protects e-mail addresses from being found by spam spiders (or any other web crawler).

== Description ==

EMAILProtect hides a normal e-mail string (e.g. "info@domain.com") by editing the HTML code.
This does not effect the outcome as the normal user sees it, but it make's it impossible for
web crawlers to locate the e-mail address.

Most crawlers these days are "non-javascript crawlers" (to speed up the crawling process)
which means that almost no crawlers can see the re-written e-mail addresses - even though
it looks just the same for the regular user.

If you look in the source code of you Wordpress page, with this plugin activated, you will see
a JavaScript (e.g. `<script type='text/javascript'>plug_emp('3;4;1;6#cominfo1domain');</script>`)
where it's supposed to be an e-mail address.

== Installation ==

The plugin works by it self. The files ('EMAILProtect.php' and 'EMAILProtect.js') should be
placed within the folder `emailprotect` - this is essential for the PHP-file to locate the
JavaScript file.

1. Upload `EMAILProtect.php` and `EMAILProtect.js` to: `/wp-content/plugins/emailprotect/`
2. Activate the plugin through the 'Plugins' menu in Wordpress

By version 1.5 you're able to decide if you want to re-write all e-mail addresses or just the
once surrounded already set to be a clickable link. You do this by changing *row 33* `EMAILProtect.php`
to: *$allClickable = 0;*

== Changelog ==

= 1.5.7 =

* Works with all surrounding HTML-tags
* Change "mailto:" links
* More cryptic changing method

= 1.5.3 =
* Minor bug fix

= 1.5.2 =
* The problem with more than one e-mail address on one row is solved
* The HTML-tag BR is added as a accepted surrounding tag.

= 1.5 =
* E-mail addresses surrounded by a link will be correctly rewritten.
* More accepted surrounding tags
* Possibility not to rewrite every tag is made
* Simple bugfix

= 1.4 =
* First stable version

== Upgrade Notice ==

= 1.5 =
* On line 33 in `EMAILProtect.php` there's a variable (*$allClickable*) which by default is set to *1*. If this would be changed to *0* only link tags (e.g. <a href="mailto:something@something.com">something@something.com</a>) will be rewritten to links, but regular e-mail strings will still be rewritten.
* For link tags to work with this version the link text must be the e-mail address.