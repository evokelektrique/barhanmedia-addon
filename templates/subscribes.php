<?php 
// Initialize Variables
$data = null;
// GET Action
$action = isset($_GET['action']) ? $_GET['action'] : null;
if(!empty($action)): 
switch ($action): ?>
<?php case 'view': ?>
    <?php 
    $data = [
        'id' => absint($_GET['id']),
    ];
    include_once(plugin_dir_path( __FILE__ ).'subscribes/show.php');
    ?>
<?php break; ?>
<?php case 'delete': ?>
<?php 
$nonce = esc_attr( $_REQUEST['_wpnonce'] );
if ( ! wp_verify_nonce( $nonce, 'bm_delete_subscribe' ) ):
    die( 'No access' );
else: 
    BmSubscribesTable::delete_subscribe( absint( $_GET['id'] ) );
?>
<div class="wrap" style="text-align: center;">
    <h2 class="barhanmedia_heading">
        <?= __('با موفقیت حذف شد', PLUGIN_NAME) ?>
        <a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
    </h2>
</div>
<?php endif; ?>
<?php break; ?>
<?php 
endswitch;
else:
    include_once(plugin_dir_path( __FILE__ ).'subscribes/list.php');
endif;
?>
