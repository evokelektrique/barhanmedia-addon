<?php 
// Initialize Variables
$data = null;
// GET Action
$action = isset($_GET['action']) ? $_GET['action'] : null;
if(!empty($action)): 
switch ($action): ?>
<?php case 'export': ?>
<?php 
    $data = [
        'id' => absint($_GET['id']),
    ];
    include_once(plugin_dir_path( __FILE__ ).'seasons/export.php') 
?>
<?php break; ?>
<?php case 'end': ?>
<?php 
    global $wpdb;
    $seasons_table_name = $wpdb->prefix . 'barhanmedia_seasons';
    $wpdb->update( $seasons_table_name, ['status' => false], ['id' => absint($_GET['id'])] );
?>
<div class="wrap" style="text-align: center;">
    <h2 class="barhanmedia_heading" style="color: green">
        <?= __('فصل با موفقیت به پایان یافت', PLUGIN_NAME) ?>
        <a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
    </h2>
</div>
<?php break; ?>
<?php case 'restart': ?>
<?php 
    global $wpdb;
    $seasons_table_name = $wpdb->prefix . 'barhanmedia_seasons';
    $wpdb->update( $seasons_table_name, ['status' => true], ['id' => absint($_GET['id'])] );
?>
<div class="wrap" style="text-align: center;">
    <h2 class="barhanmedia_heading" style="color: green">
        <?= __('فصل با موفقیت  راه اندازی شد', PLUGIN_NAME) ?>
        <a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
    </h2>
</div>
<?php break; ?>
<?php case 'new': ?>
<?php include_once(plugin_dir_path( __FILE__ ).'seasons/new.php') ?>
<?php break; ?>
<?php case 'view': ?>
    <?php 
    $data = [
        'id' => absint($_GET['id']),
    ];
    include_once(plugin_dir_path( __FILE__ ).'seasons/show.php');
    ?>
<?php break; ?>
<?php case 'delete': ?>
<?php 
$nonce = esc_attr( $_REQUEST['_wpnonce'] );
if ( ! wp_verify_nonce( $nonce, 'bm_delete_season' ) ):
    die( 'No access' );
else: 
    BmSeasonsTable::delete_season( absint( $_GET['id'] ) );
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
    include_once(plugin_dir_path( __FILE__ ).'seasons/list.php');
endif;
?>
