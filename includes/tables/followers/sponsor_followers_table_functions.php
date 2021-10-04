<?php
class BarhanMediaSponsorFollowersFunctions {
    /**
     * Insert a new sponsor
     *
     * @param array $args
     */
    public static function insert_follower( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'id'         => null,
        );

        $args       = wp_parse_args( $args, $defaults );
        $table_name = $wpdb->prefix . 'barhanmedia_sponsor_followers';

        // remove row id to determine if new or update
        $row_id = (int) $args['id'];
        unset( $args['id'] );

        if ( ! $row_id ) {

            // insert a new
            if ( $wpdb->insert( $table_name, $args ) ) {
                return $wpdb->insert_id;
            }

        } else {

            // do update method here
            if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
                return $row_id;
            }
        }

        return false;
    }

    /**
     * Get all sponsor
     *
     * @param $args array
     *
     * @return array
     */
    public static function get_all_followers( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'ASC',
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'sponsor-followers-all';
        $items     = wp_cache_get( $cache_key, 'barhanmedia' );

        if ( false === $items ) {
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_sponsor_followers ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

            wp_cache_set( $cache_key, $items, 'barhanmedia' );
        }

        return $items;
    }

    /**
     * Fetch all sponsor from database
     *
     * @return array
     */
    public static function get_sponsor_followers_count($sponsor_id) {
        global $wpdb;

        return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_sponsor_followers WHERE sponsor_id=' . $sponsor_id );
    }

    /**
     * Fetch a single sponsor from database
     *
     * @param int   $id
     *
     * @return array
     */
    public static function get_sponsor( $id = 0 ) {
        global $wpdb;

        return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_sponsors WHERE id = %d', $id ) );
    }
}