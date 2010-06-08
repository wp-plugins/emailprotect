<?php
/*
Plugin Name: EMAILProtect
Version: 1.5.2
Description: Protect e-mail addresses from SPAM spiders
Author: Jacob Hallsten
Author URI: http://amateurs-exchange.blogspot.com
Plugin URI: http://amateurs-exchange.blogspot.com/2010/05/secure-e-mail-addresses-in-wordpress.html
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
	$tags = array('strong', 'em', 'span', 'div', 'p', 'li', 'td', 'a', 'br');
	
	# Debug mode (1 = Yes, 0 = No);
	$debug_mode = 0;
	
	# Make all links clickable
	$allClickable = 1;
	
	# Clear $output
	$output = '';
	
	# Secures the accepted surounding tags from interfering with the regex
	$tagsStart = '<' . implode('[^>]*>|<', $tags) . '[^>]*>';
	$tagsEnd = '<\/' . implode('>|<\/', $tags) . '>';
	
	# Regex secure ASCII signs
	$accepted = "a-z0-9\!\#\$\%\&\*\+\-\/\=\?\^\_\`\{\|\}\~\'";
	
	# Regualar expression pattern
	$pattern = "/(^|\s|" . $tagsStart . ")(([" . $accepted . "]+)@([a-z0-9\-]+)\.([a-z\.]{2,6}))(?:\s|$|" . $tagsEnd . ")/Ui";
	
	# Breaks contents rows to an array
	$all = explode("\n", $content);
	
	# Loop all the rows
	foreach( $all as $row )
	{
		preg_match_all($pattern, $row, $matches);
		# If debug mode is active and the regex gave an error
		if( $debug_mode === 1 and $matches === false ) {
			die('An error has occurred in preg_match');
		}
		
		# Loop every found match
		for($i = 0; $i < count($matches[0]); $i++)
		{
			# Default display mode
			$displayLink = 0;
			$isLink = 0;
			
			# Removes everything except the accual HTML tag
			preg_match("/^<([a-z]+)[^>]*>$/i", trim($matches[1][$i]), $suroundingTags);
			
			# Surounding tag is a link
			if(strtolower(trim($suroundingTags[1])) === 'a')
				$isLink = 1; 
			
			# If every e-mail address should be rewritten as clickable
			# or if the surounding tag is a link.
			if($allClickable === 1 or $isLink === 1)
				$displayLink = 1;
			
			# Decides what to replace
			if($isLink === 1)
				$replace = $matches[0][$i];
			else
				$replace = $matches[2][$i];
			
			# Replaces the string with a JS
			$replacement = "<script type='text/javascript'>plug_emp('{$displayLink}','{$matches[5][$i]}','{$matches[3][$i]}','{$matches[4][$i]}');</script>";
			$row = str_replace($replace, $replacement, $row);
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
	wp_enqueue_script('EMAILProtect', $js_path, array(), '0.2');
	
	# Applies protect-filer to content.
	add_filter('the_content', 'EMAILProtect', 2);
}
?>