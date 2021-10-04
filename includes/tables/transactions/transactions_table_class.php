<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BmTransactionsTable extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'transaction',
            'plural'   => 'transactions',
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
        _e( 'پلنی یافت نشد', 'barhanmedia' );
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
            case 'id':
                return $item->authority;

            case 'price':
                return $item->price;

            case 'method':
                switch ($item->method) {
                    case 'like':
                        return __( 'لایک', 'barhanmedia' );
                        break;

                    case 'comment':
                        return __( 'کامنت', 'barhanmedia' );
                        break;

                    case 'follower':
                        return __( 'فاللور', 'barhanmedia' );
                        break;
                    
                    default:
                        return $item->method;
                        break;
                }

            case 'amount':
                return $item->amount;

            // case 'phone':
            //     return $item->phone;

            case 'status':
                if($item->status > 0) {
                    return '<span class="success_pay_status">'.'پرداخت شده'.'</span>';
                } else {
                    return '<span class="fail_pay_status">'.'کنسل شده'.'</span>';
                }

            case 'created_at':
                return $item->created_at;

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
            'authority' => __('شناسه', 'barhanmedia'),
            'price' => __('قیمت (تومان)', 'barhanmedia'),
            'method' => __('متود', 'barhanmedia'),
            'amount' => __('مقدار واحد', 'barhanmedia'),
            'status' => __('وضعیت', 'barhanmedia'),
            // 'phone' => __('شماره همراه', 'barhanmedia'),
            'created_at' => __('تاریخ', 'barhanmedia'),
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
    function column_name( $item ) {

        $delete_nonce = wp_create_nonce( 'bm_delete_transaction' );
        $actions           = array();
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=barhanmedia-transactions&action=delete&_wpnonce='.$delete_nonce.'&id=' . $item->id ), $item->id, __( 'Delete this item', 'barhanmedia' ), __( 'Delete', 'barhanmedia' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=barhanmedia-transactions&action=view&id=' . $item->id ), $item->name, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'authority' => array( 'authority', true ),
            'status' => array( 'status', true ),
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
            'trash'  => __( 'انتقال به زباله', 'barhanmedia' ),
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
            '<input type="checkbox" name="transaction_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

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

        $this->items  = BarhanMediaTransactionsFunctions::get_all_transaction( $args );

        $this->set_pagination_args( array(
            'total_items' => BarhanMediaTransactionsFunctions::get_transaction_count(),
            'per_page'    => $per_page
        ) );
    }


    public function process_bulk_action() {

        // // If the delete bulk action is triggered
        if (( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) ||
            ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )) {
            // If transaction_id array not empty
            if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])) {   
                $delete_ids = esc_sql( $_POST['transaction_id'] );
                foreach ( $delete_ids as $id ) {
                    self::delete_transaction( $id );
                }
            }
        }
    }

    // Delete Plan Method
    public static function delete_transaction($id) {
        global $wpdb;

        $transactions_table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'transactions';
        $wpdb->delete(
            "$transactions_table_name",
            [ 'ID' => $id ],
            [ '%d' ]
        );
    }

}