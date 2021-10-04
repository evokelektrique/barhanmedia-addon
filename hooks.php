<?php

// 
// Hooks
// 

// Register Admin Menu
add_action( 'admin_menu', ['BarhanMediaFunctions', 'admin'] );

// Register Style and Scripts
// Admin
add_action( 'admin_enqueue_scripts', ['BarhanMediaFunctions', 'register_styles'] );
// FrontEnd
add_action( 'wp_enqueue_scripts', ['BarhanMediaFunctions', 'register_styles'] );

// Register Subscribe Form ShortCode
add_shortcode( 'subscribe_form', ['BarhanMediaFunctions', 'subscribe_form'] );

add_action( 'admin_init', ['BmSeasonsTable', 'process_export'] );

// Ajax Media/Profile Action
add_action( 'wp_ajax_nopriv_submit_form', ['BarhanMediaFunctions', 'submit_form']);
add_action( 'wp_ajax_submit_form', ['BarhanMediaFunctions', 'submit_form']);

// Ajax Get Plans
add_action( 'wp_ajax_nopriv_get_plan', ['BarhanMediaFunctions', 'get_plan']);
add_action( 'wp_ajax_get_plan', ['BarhanMediaFunctions', 'get_plan']);

// Ajax Submit Purchase
add_action( 'wp_ajax_nopriv_submit_purchase', ['BarhanMediaFunctions', 'submit_purchase']);
add_action( 'wp_ajax_submit_purchase', ['BarhanMediaFunctions', 'submit_purchase']);

// Submit Form Shortcode
// Media Or Profile Shortcode
add_shortcode( 'submit_form', ['BarhanMediaFunctions', 'submit_form_template'] );

// Purchase Status Shortcodes
add_shortcode( 'failed_purchase_status', ['BarhanMediaFunctions', 'failed_purchase_template'] );
add_shortcode( 'successful_purchase_status', ['BarhanMediaFunctions', 'successful_purchase_template'] );
add_shortcode( 'verify_purchase', ['BarhanMediaFunctions', 'verify_purchase_template'] );

// Sponsors List Shortcode
add_shortcode( 'sponsors', ['BarhanMediaFunctions', 'sponsors_list'] );

// Fetcher Shortcode
add_shortcode( 'fetch', ['BarhanMediaFunctions', 'fetch_template'] );
// Ajax Send Purchase Notification
add_action( 'wp_ajax_nopriv_send_notification', ['BarhanMediaFunctions', 'send_notification']);
add_action( 'wp_ajax_send_notification', ['BarhanMediaFunctions', 'send_notification']);
// Ajax Fetch Items
add_action( 'wp_ajax_nopriv_fetch', ['BarhanMediaFunctions', 'fetch']);
add_action( 'wp_ajax_fetch', ['BarhanMediaFunctions', 'fetch']);
