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
 * Description:       📝 Add menu links that take you straight to your drafts.
 * Version:           1.0
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

/**
 * Add meta to plugin details
 *
 * Add options to plugin meta line
 *
 * @param    string $links  Current links.
 * @param    string $file   File in use.
 * @return   string         Links, now with settings added.
 */
function draft_links_plugin_meta( $links, $file ) {

	if ( false !== strpos( $file, 'draft-links.php' ) ) {

		$links = array_merge(
			$links,
			array( '<a href="https://github.com/dartiss/draft-links">' . __( 'Github', 'draft-links' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/draft-links">' . __( 'Support', 'draft-links' ) . '</a>' ),
			array( '<a href="https://artiss.blog/donate">' . __( 'Donate', 'draft-links' ) . '</a>' ),
			array( '<a href="https://wordpress.org/support/plugin/draft-links/reviews/#new-post">' . __( 'Write a Review', 'draft-links' ) . '&nbsp;⭐️⭐️⭐️⭐️⭐️</a>' )
		);
	}

	return $links;
}

add_filter( 'plugin_row_meta', 'draft_links_plugin_meta', 10, 2 );

/**
 * Add drafts to menu
 *
 * Add draft counts to the post and pages menus
 */
function draft_links_add_to_menu() {

	$author = get_current_user_id();

	// Get total number of draft posts. If more than zero add a sub-menu option.

	$all_posts = draft_links_count_all_drafts( 'post' );
	if ( $all_posts > 0 ) {

		add_submenu_page( 'edit.php', '', __( 'All Drafts', 'draft-links' ) . ' <span class=\'update-plugins count-' . $all_posts . '\'><span class=\'update-count\'>' . $all_posts . '</span></span>', 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post' ) );

		// Get total number of draft posts for current user. If more than zero add a sub-menu option.

		$your_posts = draft_links_count_my_drafts( 'post', $author );
		if ( $your_posts > 0 && $your_posts !== $all_posts ) {
			add_submenu_page( 'edit.php', '', __( 'My Drafts', 'draft-links' ) . ' <span class=\'update-plugins count-' . $your_posts . '\'><span class=\'update-count\'>' . $your_posts . '</span></span>', 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post&author=' . $author . '' ) );
		}
	}

	$all_pages = draft_links_count_all_drafts( 'page' );
	if ( $all_pages > 0 ) {

		add_submenu_page( 'edit.php?post_type=page', '', __( 'All Drafts', 'draft-links' ) . ' <span class=\'update-plugins\'><span class=\'update-count\'>' . $all_pages . '</span></span>', 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page' ) );

		// Get total number of draft pages for current user. If more than zero add a sub-menu option.

		$your_pages = draft_links_count_my_drafts( 'page', $author );
		if ( $your_pages > 0 && $your_pages !== $all_pages ) {
			add_submenu_page( 'edit.php?post_type=page', '', __( 'My Drafts', 'draft-links' ) . ' <span class=\'update-plugins\'><span class=\'update-count\'>' . $your_pages . '</span></span>', 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page&author=' . $author . '' ) );
		}
	}
}

add_action( 'admin_menu', 'draft_links_add_to_menu' );

/**
 * Count all drafts
 *
 * Count the total number of drafts for a specific post tyle
 *
 * @param  string $type File type.
 * @return intval       Number of drafts.
 */
function draft_links_count_all_drafts( $type ) {
	return intval( wp_count_posts( $type )->draft );
}

/**
 * Count my drafts
 *
 * Count the total number of drafts for a specific person and post tyle
 *
 * @param  string $type   File type.
 * @param  string $author Author ID.
 * @return intval         Number of drafts.
 */
function draft_links_count_my_drafts( $type, $author ) {

	$args = array(
		'post_type'      => $type,
		'author'         => $author,
		'post_status'    => 'draft',
		'posts_per_page' => 99,
	);

	$query = new WP_Query( $args );
	return intval( count( $query->get_posts() ) );
}
