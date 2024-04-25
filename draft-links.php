<?php
/**
 * Draft Links
 *
 * @package           draft-links
 * @author            David Artiss
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       Draft Links
 * Plugin URI:        https://wordpress.org/support/plugin/draft-links/
 * Description:       Add menu links that take you straight to your drafts.
 * Version:           1.1
 * Requires at least: 4.6
 * Requires PHP:      5.3
 * Author:            David Artiss
 * Author URI:        https://artiss.blog
 * Text Domain:       draft-links
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// Define global to hold the plugin base file name.

if ( ! defined( 'DRAFT_LINKS_PLUGIN_BASE' ) ) {
	define( 'DRAFT_LINKS_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}

// Include the shared functions.

require_once plugin_dir_path( __FILE__ ) . 'inc/shared.php';

require_once plugin_dir_path( __FILE__ ) . 'inc/add-to-menu.php';
