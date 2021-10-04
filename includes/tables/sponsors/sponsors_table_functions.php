<?php
class BarhanMediaSponsorsFunctions {
    /**
     * Insert a new sponsor
     *
     * @param array $args
     */
    public static function insert_sponsor( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'id'         => null,
            'page_username' => '',
        );

        $args       = wp_parse_args( $args, $defaults );
        $table_name = $wpdb->prefix . 'barhanmedia_sponsors';

        // some basic validation

        // remove row id to determine if new or update
        $row_id = (int) $args['id'];
        unset( $args['id'] );

        // Fetch instagram account by username
        $instagram = BarhanMedia::login_to_instagram();
        $account = BarhanMedia::get_by_username($instagram, $args['page_username']);
        $args['page_id'] = $account->getId();
        $args['page_full_name'] = $account->getFullName();
        $args['page_description'] = $account->getBiography();
        $args['page_picture'] = $account->getProfilePicUrl();
        $args['is_private'] = $account->isPrivate();
        $args['is_verified'] = $account->isVerified();

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
    public static function get_all_sponsor( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'number'     => 20,
            'offset'     => 0,
            'orderby'    => 'id',
            'order'      => 'ASC',
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'sponsor-all';
        $items     = wp_cache_get( $cache_key, 'barhanmedia' );

        if ( false === $items ) {
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_sponsors ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

            wp_cache_set( $cache_key, $items, 'barhanmedia' );
        }

        return $items;
    }

    /**
     * Fetch all sponsor from database
     *
     * @return array
     */
    public static function get_sponsor_count() {
        global $wpdb;

        return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_sponsors' );
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

    public static function get_all_season_sponsors($season_id) {
        global $wpdb;
        return (int)$wpdb->get_results( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'barhanmedia_sponsors WHERE season_id='.$season_id.' ORDER BY id DESC');
    }
}