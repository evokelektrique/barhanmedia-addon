<?php

class BarhanMediaSeasonsFunctions {

    /**
     * Insert a new season
     *
     * @param array $args
     */
    public static function insert_season( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'id'         => null,
            'title'      => '',
            'created_at' => current_time( 'mysql' ),
        );

        $args       = wp_parse_args( $args, $defaults );
        $table_name = $wpdb->prefix . 'barhanmedia_seasons';

        // some basic validation

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
     * Get all season
     *
     * @param $args array
     *
     * @return array
     */
    public static function get_all_season( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'ASC',
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'season-all';
        $items     = wp_cache_get( $cache_key, 'barhanmedia' );

        if ( false === $items ) {
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_seasons ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

            wp_cache_set( $cache_key, $items, 'barhanmedia' );
        }

        return $items;
    }

    /**
     * Fetch all season from database
     *
     * @return array
     */
    public static function get_season_count() {
        global $wpdb;

        return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_seasons' );
    }

    /**
     * Fetch a single season from database
     *
     * @param int   $id
     *
     * @return array
     */
    public static function get_season( $id = 0 ) {
        global $wpdb;

        return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_seasons WHERE id = %d', $id ) );
    }
}