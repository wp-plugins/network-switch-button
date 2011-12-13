<?php
/*
Plugin Name: Network Switch Button
Plugin URI: http://premium.wpmudev.org/project/network-switch-button
Description: Add a Network Admin / Site Admin button to your WordPress Multisite Dashboard
Version: 1.1
Author: Ve Bailovity (Incsub)
Author URI: http://premium.wpmudev.org
WDP ID: 235

Copyright 2009-2011 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * If you wish to show the link as button rather then the link,
 * add this to your wp-config.php:
 * 	define ('NSB_SHOW_BUTTON', true);
 */
if (!defined('NSB_SHOW_BUTTON')) define ('NSB_SHOW_BUTTON', false);


function nsb_network_switch () {
	if (!is_super_admin()) return false;
	$style = (defined('NSB_SHOW_BUTTON') && NSB_SHOW_BUTTON) ?
		"margin: 0 10px; height: 13px; margin-top: 4px; padding: 5px;"
		:
		"line-height: 20px; padding: 6px 8px 5px;"
	;
	$link_style = (defined('NSB_SHOW_BUTTON') && NSB_SHOW_BUTTON)
		? '' :
		'#wphead .nsb_switch a:hover { text-decoration: underline; }';
	$class = (defined('NSB_SHOW_BUTTON') && NSB_SHOW_BUTTON) ? 'button' : '';
	echo <<<EOS
<style type="text/css">
.nsb_switch {
	float: right;
	$style
}

.nsb_switch a, .nsb_switch a:visited, .nsb_switch a:hover, .nsb_switch a:active {
	color: #444;
	text-decoration: none;
}
$link_style
</style>
EOS;

	if (!WP_NETWORK_ADMIN) {
		$switch_text = __("Network Admin");
		$switch_url = network_admin_url('/index.php');
		echo <<<EOSTN
<script type="text/javascript">
(function ($) {
$(function () {
	var el = $("#wp-admin-bar-my-account").length ? $("#wp-admin-bar-my-account") : $("#site-heading");
	el.after(
		'<div class="nsb_switch admin_area $class"><a href="$switch_url">$switch_text</a></div>'
	);
});
})(jQuery);
</script>
EOSTN;
	} else {
		$switch_text = __("Site Admin");
		$switch_url = admin_url('/index.php');
		echo <<<EOSTS
<script type="text/javascript">
(function ($) {
$(function () {
	var el = $("#wp-admin-bar-my-account").length ? $("#wp-admin-bar-my-account") : $("#site-heading");
	el.after(
		'<div class="nsb_switch admin_area $class"><a href="$switch_url">$switch_text</a></div>'
	);
});
})(jQuery);
</script>
EOSTS;

	}
}

// Initialize
if (is_admin()) {
	add_action('admin_head', 'nsb_network_switch');
}