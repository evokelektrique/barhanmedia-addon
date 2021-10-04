<?php 
// Initialize Variables
$data = null;
// GET Action
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
if(!empty($action)): 
switch ($action): ?>
<?php case 'new': ?>
<?php include_once(plugin_dir_path( __FILE__ ).'plans/new.php') ?>
<?php break; ?>
<?php case 'view': ?>
    <?php 
    $data = [
        'id' => $id,
    ];
    include_once(plugin_dir_path( __FILE__ ).'plans/show.php');
    ?>
<?php break; ?>
<?php case 'delete': ?>
<?php 
$nonce = esc_attr( $_REQUEST['_wpnonce'] );
if ( ! wp_verify_nonce( $nonce, 'bm_delete_plan' ) ):
    die( 'No access' );
else: 
    BmPlansTable::delete_plan( absint( $_GET['id'] ) );
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
    include_once(plugin_dir_path( __FILE__ ).'plans/list.php');
endif;
?>
