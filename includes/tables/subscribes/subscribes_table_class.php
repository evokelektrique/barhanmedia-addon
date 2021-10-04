<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BmSubscribesTable extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'subscribe',
            'plural'   => 'subscribes',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'شرکت کننده ای پیدا نشد', 'barhanmedia' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'instagram_page_address':
                return $item->instagram_page_address;

            case 'phone':
                return $item->phone;

            case 'first_name':
                return $item->first_name;

            case 'last_name':
                return $item->last_name;

            case 'token':
                return $item->token;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'instagram_page_address'      => __( 'آدرس صفحه اینستاگرام', 'barhanmedia' ),
            'phone'      => __( 'شماره همراه', 'barhanmedia' ),
            'first_name'      => __( 'نام', 'barhanmedia' ),
            'last_name'      => __( 'نام خانوادگی', 'barhanmedia' ),
            'token'      => __( 'کد قرعه کشی', 'barhanmedia' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_instagram_page_address( $item ) {

        $delete_nonce = wp_create_nonce( 'bm_delete_subscribe' );
        $actions           = array();
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=barhanmedia-subscribes&action=delete&_wpnonce='.$delete_nonce.'&id=' . $item->id ), $item->id, __( 'Delete this item', 'barhanmedia' ), __( 'حذف', 'barhanmedia' ) );
        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=barhanmedia-subscribes&action=view&id=' . $item->id ), $item->instagram_page_address, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'bulk-delete'  => __( 'انتقال به سطل زباله', 'barhanmedia' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="subscribe_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=barhanmedia-subscribes' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->process_bulk_action();
        // $this->handle_actions();

        $per_page              = 5;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = BarhanMediaSubscribesFunctions::get_all_subscribe( $args );

        $this->set_pagination_args( array(
            'total_items' => BarhanMediaSubscribesFunctions::get_subscribe_count(),
            'per_page'    => $per_page
        ) );
    }


    public function process_bulk_action() {

        // // If the delete bulk action is triggered
        if (( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) ||
            ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )) {
            // If subscribe_id array not empty
            if(isset($_POST['subscribe_id']) && !empty($_POST['subscribe_id'])) {   
                $delete_ids = esc_sql( $_POST['subscribe_id'] );
                foreach ( $delete_ids as $id ) {
                    self::delete_subscribe( $id );
                }
            }
        }
    }

    // Delete Subscribe Method
    public static function delete_subscribe($id) {
        global $wpdb;

        $subscribes_table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'subscribes';
        $wpdb->delete(
            "$subscribes_table_name",
            [ 'ID' => $id ],
            [ '%d' ]
        );
    }
}