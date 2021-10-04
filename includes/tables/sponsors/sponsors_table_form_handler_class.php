<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class SponsorsFormHandler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the sponsor new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_sponsor'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', 'barhanmedia' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'barhanmedia' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=barhanmedia-sponsors' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $page_username = isset( $_POST['page_username'] ) ? sanitize_text_field( $_POST['page_username'] ) : '';
        $season_id = isset( $_POST['season_id'] ) ? sanitize_text_field( $_POST['season_id'] ) : '';

        // some basic validation
        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'page_username' => $page_username,
            'season_id' => $season_id,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = BarhanMediaSponsorsFunctions::insert_sponsor( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = BarhanMediaSponsorsFunctions::insert_sponsor( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new SponsorsFormHandler();