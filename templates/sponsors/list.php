
<div class="wrap">
    <h2 class="barhanmedia_heading">
        <?php _e( 'اسپانسر ها', 'barhanmedia' ); ?> 
        <a href="<?php echo admin_url( 'admin.php?page=barhanmedia-sponsors&action=new' ); ?>" class="add-new-h2"><?php _e( 'جدید', 'barhanmedia' ); ?></a>
    </h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">
        <?php
        $list_table = new BmSponsorsTable();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>

<?php include_once(plugin_dir_path(__FILE__) . '../footer.php') ?>

