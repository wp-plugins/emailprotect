<?php
/*
Plugin Name: EMAILProtect
Version: 1.4
Description: Protect e-mail addresses from SPAM spiders
Author: Jacob Hallsten
Author URI: http://amateurs-exchange.blogspot.com
Thanks: Deadmau5
*/

function EMAILProtect($content)
{
	if (is_feed()) return $content;
	
	/* --------------------------------------------------------------
	
	 EMAILProtect was written because of the lacking funtionality
	 Wordpress has when it comes to handling e-mail addresses.
	 Spiders search the web to find these addresses but with
	 just a simple JS script you can almost get rid of everyone
	 of these.
	
	 I will keep posting updates to this script to make it as hard
	 as possible for evil spiders from finding e-mail addresses.
	
	-------------------------------------------------------------- */
	
	# Accepted surounding tags
	$tags = array('strong', 'em', 'span', 'div', 'p', 'li', 'td');
	
	# Debug mode (1 = Yes, 0 = No);
	$debug_mode = 0;
	
	# Clear $output
	$output = '';
	
	# Secures the accepted surounding tags from interfering with the regex
	$tagsStart = '<' . implode('[^>]*>|<', $tags) . '>';
	$tagsEnd = '<\/' . implode('>|<\/', $tags) . '>';
	
	# Regex secure ASCII signs
	$accepted = "a-z0-9\!\#\$\%\&\*\+\-\/\=\?\^\_\`\{\|\}\~\'";
	
	# Regualar expression pattern
	$pattern = "/(?:^|\s|" . $tagsStart . ")(([" . $accepted . "]+)@([a-z0-9\-]+)\.([a-z\.]{2,6}))(?:\s|$|" . $tagsEnd . ")/Ui";
	
	# Breaks contents rows to an array
	$all = explode("\n", $content);
	
	# Loop all the rows
	foreach( $all as $row )
	{
		preg_match($pattern, $row, $matches);
		
		# If debug mode is active and the regex gave an error
		if( $debug_mode === 1 and $matches === false ) {
			die('An error has occurred in preg_match');
		}
		
		if( count($matches) > 0 )
		{
			# Replaces the string with a JS
			$replacement = "<script type='text/javascript'>plug_emp('{$matches[4]}','{$matches[2]}','{$matches[3]}');</script>";
			$row = str_replace($matches[1], $replacement, $row);
		}
		
		$output .= $row . "\n";
	}
	
	return $output;
}

if( !is_admin() )
{
	# Get the external URL to the Wordpress installation folder
	$wpurl = get_bloginfo('wpurl');
	$js_path = $wpurl . '/wp-content/plugins/emailprotect/EMAILProtect.js';
	
	# Add the JS-file to the HEAD-tag
	wp_enqueue_script('EMAILProtect', $js_path, array(), '0.1');
	
	# Applies protect-filer to content.
	add_filter('the_content', 'EMAILProtect', 2);
}
?>