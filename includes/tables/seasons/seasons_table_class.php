<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BmSeasonsTable extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'season',
            'plural'   => 'seasons',
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
        _e( 'فصلی پیدا نشد', 'barhanmedia' );
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
            case 'title':
                return $item->title;

            case 'shortcode':
                $season_id = $item->id;
                return "<input style='max-width:100%;' type='text' readonly='' value='[subscribe_form id=$season_id]' />";

            case 'sponsors_shortcode':
                $season_id = $item->id;
                return "<input style='max-width:100%;' type='text' readonly='' value='[sponsors id=$season_id]' />";

            case 'subscribers_count':
                return BarhanMediaSubscribesFunctions::get_all_season_subscribers($item->id);

            case 'sponsors_count':
                return BarhanMediaSponsorsFunctions::get_all_season_sponsors($item->id);

            case 'end_season':
                if($item->status) {
                    return "<a href='".sprintf(admin_url( 'admin.php?page=barhanmedia-seasons&action=end&id=' . $item->id ), $item->id, __( 'پایان دادن به فصل', 'barhanmedia' ), __( 'پایان', 'barhanmedia' ) )."' class='button button-primary'>پایان  دادن به فصل</a>";
                } else {
                    return "<a href='".sprintf(admin_url( 'admin.php?page=barhanmedia-seasons&action=restart&id=' . $item->id ), $item->id, __( 'شروع دوباره فصل', 'barhanmedia' ), __( 'پایان', 'barhanmedia' ) )."' class='button button-primary'>شروع دوباره فصل</a>";
                }

            case 'export':
                // return "<a href='".sprintf(admin_url( 'admin.php?page=barhanmedia-seasons&action=export&id=' . $item->id ), $item->id, __( 'خروجی CSV', 'barhanmedia' ), __( 'خورجی csv', 'barhanmedia' ) )."' class='button button-primary'>خروجی CSV</a>";
                return "
                <form method='POST' action=''>
                    <button type='submit' name='submit_export' class='button button-primary'>
                    دریافت CSV
                    </button>
                    <input type='hidden' name='season_id' value='".$item->id."' />
                </form>
                ";


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
            'cb'                 => '<input type="checkbox" />',
            'title'              => __( 'عنوان', 'barhanmedia' ),
            'subscribers_count'  => __( 'تعداد شرکت کنندگان', 'barhanmedia' ),
            'sponsors_count'  => __( 'تعداد اسپانسر ها', 'barhanmedia' ),
            'shortcode'          => __( 'کد کوتاه فرم شرکت کننده', 'barhanmedia' ),
            'sponsors_shortcode' => __( 'کد کوتاه لیست اسپانسر ها', 'barhanmedia' ),
            'end_season'  => __( 'پایان فصل', 'barhanmedia' ),
            'export'  => __( 'خروجی شرکت کنندگان', 'barhanmedia' ),
            'created_at'         => __( 'تاریخ ایجاد', 'barhanmedia' ),
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
    function column_title( $item ) {
        $delete_nonce = wp_create_nonce( 'bm_delete_season' );
        $actions           = array();
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=barhanmedia-seasons&action=delete&_wpnonce='.$delete_nonce.'&id=' . $item->id ), $item->id, __( 'Delete this item', 'barhanmedia' ), __( 'Delete', 'barhanmedia' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=barhanmedia-seasons&action=view&id=' . $item->id ), $item->title, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array( 'title', true ),
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
            'trash'  => __( 'انتقال به سطل زباله', 'barhanmedia' ),
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
            '<input type="checkbox" name="season_id[]" value="%d" />', $item->id
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

        $this->items  = BarhanMediaSeasonsFunctions::get_all_season( $args );

        $this->set_pagination_args( array(
            'total_items' => BarhanMediaSeasonsFunctions::get_season_count(),
            'per_page'    => $per_page
        ) );
    }


    public static function process_export() {
        if(isset($_POST['submit_export'])) {
            global $wpdb;
            $season = BarhanMediaSeasonsFunctions::get_season(absint($_POST['season_id']));
            $filename = $season->title;
            $date = date("Y-m-d H:i:s");
            $output = fopen("php://output", 'w');
            // UTF-8 Execl
            fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'barhanmedia_subscribes', ARRAY_A);

            fputcsv( 
                $output, 
                array(
                    'id', 
                    'first_name', 
                    'last_name', 
                    'instagram_page_address', 
                    'token'
                ),
                "\t"
            );
            foreach ( $result as $key => $value ) {
                $modified_values = array(
                    $value['id'],
                    $value['first_name'],
                    $value['last_name'],
                    $value['instagram_page_address'],
                    $value['token'],
                );
                fputcsv( $output, $modified_values, "\t" );
            }
            fclose($output);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header('Content-Type: text/csv; charset=utf-8');
            // header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $filename . " " . $date . ".csv\";" );
            // header('Content-Disposition: attachment; filename=lunchbox_orders.csv');
            header("Content-Transfer-Encoding: binary");
            exit;
        }
    }
    public function process_bulk_action() {
        // If the delete bulk action is triggered
        if (( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) ||
            ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )) {
            // If sponsor_id array not empty
            if(isset($_POST['sponsor_id']) && !empty($_POST['sponsor_id'])) {   
                $delete_ids = esc_sql( $_POST['sponsor_id'] );
                foreach ( $delete_ids as $id ) {
                    self::delete_season( $id );
                }
            }
        }
    }

    // Delete sponsor Method
    public static function delete_season($id) {
        global $wpdb;

        $sponsors_table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'seasons';
        $wpdb->delete(
            "$sponsors_table_name",
            [ 'ID' => $id ],
            [ '%d' ]
        );
    }

}