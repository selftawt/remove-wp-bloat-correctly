<?php
/**
 * Plugin Name:       Remove WP Bloat — Correctly
 * Plugin URI:        https://selftawt.com/disable-wp-bloat-correctly
 * Description:       The right way to remove or unnecessary bloats in WordPress making your site clean, lean, and mean.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Rey Sanchez
 * Author URI:        https://selftawt.com
 * License:           GPL-3.0
 */

namespace Selftawt\RWPBC;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( is_admin() ) {
    add_filter( 'enable_post_by_email_configuration', '__return_false' );
    add_filter( 'wp_is_application_passwords_available', '__return_false' );
    
    remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
    remove_action( 'wp_scheduled_auto_draft_delete', 'wp_delete_auto_drafts' );

    add_filter( 'admin_footer_text', '__return_empty_string' );
    add_filter( 'update_footer', '__return_empty_string', 999 );

    add_action( 'admin_menu', function() {
        remove_submenu_page( 'tools.php', 'export-personal-data.php' );
        remove_submenu_page( 'tools.php', 'erase-personal-data.php' );
        remove_submenu_page( 'options-general.php', 'options-privacy.php' );  
    } );

    add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
        $wp_admin_bar->remove_node( 'wp-logo' );
    }, 20 );
}

/** WordPress meta generator */
add_filter( 'the_generator', '__return_empty_string' );

/** Feed links */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/** REST API filters */
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'wp_head', 'rsd_link' );

/** XML-RPC */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

/** Shortlink */
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );

/** Core block patterns */
remove_theme_support( 'block-templates' );
remove_theme_support( 'core-block-patterns' );

/** Openverse */
add_filter( 'block_editor_settings_all', function( $settings ) {
    $settings['enableOpenverseMediaCategory'] = false;
    return $settings;
}, 10 );