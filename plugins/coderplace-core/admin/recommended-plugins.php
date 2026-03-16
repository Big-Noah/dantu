<?php
/**
 * The `recommended_plugins` global array. To work with tgmp and ocdi both.
 *
 * @package CoderPlace
 */

global $theme_plugins;
if ( !isset( $theme_plugins ) && defined( 'TMTHEME_PATH' ) ) {
	require_once TMTHEME_PATH . '/admin/theme-plugins.php';
} 

$recommended_plugins = array();
global $recommended_plugins;

$common_plugins = array();

if ( isset ($theme_plugins) ) {
	$recommended_plugins = array_merge( $theme_plugins, $common_plugins );
} else {
	$recommended_plugins = $common_plugins;
}
