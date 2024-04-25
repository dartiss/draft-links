<?php
/**
 * Add to menu
 *
 * Functions to add the draft counters to the admin menu.
 *
 * @package draft-links
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add drafts to menu
 *
 * Add draft counts to the post and pages menus
 */
function dlx_add_to_menu() {

	$author = get_current_user_id();

	// Get total number of draft posts. If more than zero add a sub-menu option.

	$all_posts = dlx_count_all_drafts( 'post' );
	if ( $all_posts > 0 ) {

		add_submenu_page( 'edit.php', '', __( 'All Drafts', 'draft-links' ) . ' <span class=\'update-plugins count-' . $all_posts . '\'><span class=\'update-count\'>' . $all_posts . '</span></span>', 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post' ) );

		// Get total number of draft posts for current user. If more than zero add a sub-menu option.

		$your_posts = dlx_count_my_drafts( 'post', $author );
		if ( $your_posts > 0 && $your_posts !== $all_posts ) {
			add_submenu_page( 'edit.php', '', __( 'My Drafts', 'draft-links' ) . ' <span class=\'update-plugins count-' . $your_posts . '\'><span class=\'update-count\'>' . $your_posts . '</span></span>', 'edit_posts', esc_url( 'edit.php?post_status=draft&post_type=post&author=' . $author . '' ) );
		}
	}

	$all_pages = dlx_count_all_drafts( 'page' );
	if ( $all_pages > 0 ) {

		add_submenu_page( 'edit.php?post_type=page', '', __( 'All Drafts', 'draft-links' ) . ' <span class=\'update-plugins\'><span class=\'update-count\'>' . $all_pages . '</span></span>', 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page' ) );

		// Get total number of draft pages for current user. If more than zero add a sub-menu option.

		$your_pages = dlx_count_my_drafts( 'page', $author );
		if ( $your_pages > 0 && $your_pages !== $all_pages ) {
			add_submenu_page( 'edit.php?post_type=page', '', __( 'My Drafts', 'draft-links' ) . ' <span class=\'update-plugins\'><span class=\'update-count\'>' . $your_pages . '</span></span>', 'edit_pages', esc_url( 'edit.php?post_status=draft&post_type=page&author=' . $author . '' ) );
		}
	}
}

add_action( 'admin_menu', 'dlx_add_to_menu' );

/**
 * Count all drafts
 *
 * Count the total number of drafts for a specific post tyle
 *
 * @param  string $type File type.
 * @return intval       Number of drafts.
 */
function dlx_count_all_drafts( $type ) {
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
function dlx_count_my_drafts( $type, $author ) {

	$args = array(
		'post_type'      => $type,
		'author'         => $author,
		'post_status'    => 'draft',
		'posts_per_page' => 99,
	);

	$query = new WP_Query( $args );
	return intval( count( $query->get_posts() ) );
}
