<?php
class BarhanMediaPlansFunctions {
    /**
     * Insert a new plan
     *
     * @param array $args
     */
    public static function insert_plan( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'id'         => null,
            'created_at' => current_time( 'mysql' ),
        );

        $args       = wp_parse_args( $args, $defaults );
        $table_name = $wpdb->prefix . 'barhanmedia_plans';

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
     * Get all plan
     *
     * @param $args array
     *
     * @return array
     */
    public static function get_all_plan( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'ASC',
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'plan-all';
        $items     = wp_cache_get( $cache_key, 'barhanmedia' );

        if ( false === $items ) {
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_plans ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

            wp_cache_set( $cache_key, $items, 'barhanmedia' );
        }

        return $items;
    }

    /**
     * Fetch all plan from database
     *
     * @return array
     */
    public static function get_plan_count() {
        global $wpdb;

        return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_plans' );
    }

    /**
     * Fetch a single plan from database
     *
     * @param int   $id
     *
     * @return array
     */
    public static function get_plan( $id = 0 ) {
        global $wpdb;

        return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_plans WHERE id = %d', $id ) );
    }   

    public static function get_plan_by_type( $type = 'like', $amount = 0, $limit = 1 ) {
        global $wpdb;

        return $wpdb->get_row(
            $wpdb->prepare(
                'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_plans WHERE type = %s AND amount >= %d LIMIT %d', 
                $type, $amount, $limit 
            )
        );
    }
}