<?php
/*
Plugin Name: EMAILProtect
Version: 1.5.8
Description: Protects e-mail addresses from being found by spam spiders (or any other web crawler).
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
	
	# Debug mode (1 = Yes, 0 = No);
	$debug_mode = 0;
	
	# Make all links clickable
	$allClickable = 1;
	
	# Clear vars
	$output = '';
	
	# Regex secure ASCII signs
	$accepted = "a-z0-9\.\!\#\$\%\&\*\+\-\/\=\?\^\_\`\{\|\}\~\'";
	
	# Email regex pattern
	$email = '[' . $accepted . ']+@(?:[a-z0-9\-]+\.)?[a-z0-9\-]+\.[a-z]{2,6}';
	
	# Email as a link
	$alink = '<a[\w\s\=\"\']*href=(?:\'|\")mailto:(?:\s)?(' . $email . ')(?:\"|\')[^>]*>([^<]+)<\/a>';
	
	# Regualar expression pattern
	$pattern = '/(?:^|\s|<\/?[a-z]+[^>]*>)(' . $alink . '|' . $email . ')(?:<\/?[a-z]+[^>]*>|\s|$)/Ui';
	
	# Breaks contents rows to an array
	$all = explode("\n", $content);
	
	# Loop all the rows
	foreach( $all as $row )
	{
		@preg_match_all($pattern, $row, $matches);
		
		# If debug mode is active and the regex gave an error
		if( $debug_mode === 1 and $matches === false ) {
			die('An error has occurred in preg_match_all');
			return;
		}
		elseif($matches === false ) {
			return;
		}
		
		# Removes unnecessary parts
		unset($matches[0]);
		$matches = array_values($matches);
		
		# Loop every found match
		for( $i = 0; $i < count( $matches[0] ); $i++ )
		{
			# Default display mode
			$displayLink = 'false';
			$isLink = 0;
			
			$p[$i]['rewrite'] = $matches[0][$i];
			$p[$i]['email'] = $matches[1][$i];
			$p[$i]['text'] = str_replace(";emp:", "&#59;emp&#58;", $matches[2][$i]);
			
			# If match isn't already a link
			if( empty($p[$i]['email']) )
				$p[$i]['email'] = $matches[0][$i];
			
			# Surounding tag is a link
			if( !empty($p[$i]['text']) )
				$isLink = 1; 
			
			# If every e-mail address should be rewritten as clickable
			# or if the surounding tag is a link.
			if($allClickable === 1 or $isLink === 1)
				$displayLink = 'true';
			
			# Locates the parts of the email
			preg_match("/([^@]+)@([^\.]+)\.([a-z\.]+)/i", $p[$i]['email'], $emailParts);
			unset( $emailParts[0] );
			$emailParts = array_values($emailParts);
			
			# Decides what order to place to parts
			$order = array($emailParts[2], $emailParts[1], $emailParts[0], $p[$i]['text']);
			$parts = array();
			
			# Shuffle-signs
			$alpha = "abcdef1234560#.-*";
			
			# Separation mark
			$separate = ';emp:';
			
			foreach( $order as $part ){
				if( !empty($part) )
					$parts[] = substr(str_shuffle($alpha), 3, mt_rand(0, strlen($alpha))).$separate.$part;
			}
			
			# Prepair for re-writing
			$plug_emp = implode($separate, $parts);
			$replacement = "<script type='text/javascript'>plug_emp({$displayLink}, '={$plug_emp}');</script>";
			
			# Re-write the email to a JavaScript
			$row = str_replace($p[$i]['rewrite'], $replacement, $row);
		}
		
		# Put all rows back together
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
	wp_enqueue_script('EMAILProtect', $js_path, array(), '0.8');
	
	# Applies protect-filer to content.
	add_filter('the_content', 'EMAILProtect', 2);
}
?>