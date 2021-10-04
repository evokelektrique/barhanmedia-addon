<?php
/* 
 * exit uninstall if not called by WP
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

global $wpdb;

// Tables Variable
$tables = [];

// Appending Table Names Into $tables
array_push($tables, $wpdb->prefix . PLUGIN_NAME . '_' . 'subscribes');

// drop the table from the database.
foreach($tables as &$table) {
	$wpdb->query( "DROP TABLE IF EXISTS $table" );
}