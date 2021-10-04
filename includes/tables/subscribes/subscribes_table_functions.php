<?php
class BarhanMediaSubscribesFunctions {
	/**
	 * Get all subscribe
	 */
	public static function get_all_subscribe( $args = array() ) {
		global $wpdb;

		$defaults = array(
			'number'     => 20,
			'offset'     => 0,
			'orderby'    => 'id',
			'order'      => 'ASC',
		);

		$args      = wp_parse_args( $args, $defaults );
		$cache_key = 'subscribe-all';
		$items     = wp_cache_get( $cache_key, 'barhanmedia' );

		if ( false === $items ) {
			$items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_subscribes ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

			wp_cache_set( $cache_key, $items, 'barhanmedia' );
		}

		return $items;
	}

	/**
	 * Fetch all subscribe from database
	 */
	public static function get_subscribe_count() {
		global $wpdb;

		return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_subscribes' );
	}

	/**
	 * Fetch a single subscribe from database
	 */
	public static function get_subscribe( $id = 0 ) {
		global $wpdb;

		return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_subscribes WHERE id = %d', $id ) );
	}

	public static function get_all_season_subscribers($season_id) {
		global $wpdb;
		return (int)$wpdb->get_results( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_subscribes WHERE season_id='.$season_id.' ORDER BY id DESC');
	}

	public static function get_all_subscribers($time='-1 week') {
		global $wpdb;
		$week_ago_date = date('Y-m-d', strtotime($time));
		$current_date = date('Y-m-d', strtotime('now'));
		$items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_subscribes WHERE DATE(created_at) BETWEEN "'.$week_ago_date.'" AND "'.$current_date.'" ORDER BY id DESC');
		return $items;
	}
}