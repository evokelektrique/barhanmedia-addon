
<div class="wrap">
    <h2 class="barhanmedia_heading">
        <?php _e( 'لیست تراکنش ها', 'barhanmedia' ); ?> 
    </h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new BmTransactionsTable();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>

<?php include_once(plugin_dir_path(__FILE__) . '../footer.php') ?>