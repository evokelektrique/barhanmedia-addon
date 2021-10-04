<?php 
if(isset($_GET['transaction_id']) && is_user_logged_in()):

global $wpdb;

// Get transaction
$transaction_id = $_GET['transaction_id'];
$transaction = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_transactions WHERE fallback_url = %d', $transaction_id ) );
if(!empty($transaction) && $transaction->status > 0):
$base_url 			= get_option( 'fallback_page' );
$uuid 				= $transaction->fallback_url;
$full_fallback_url 	= "$base_url?transaction_id=$uuid";
?>


<!-- Fetch Wrapper -->
<div class="loading_fetch">
	<h3 class="fetch_loading_title">اطلاعات تراکنش</h3>
	<ul>
		<li class="transaction_input">صفحه: <?= $transaction->input ?></li>
		<li class="transaction_method">نوع: 
			<?php if($transaction->method === 'like') echo "لایک"; ?>
			<?php if($transaction->method === 'comment') echo "کامنت"; ?>
			<?php if($transaction->method === 'follower') echo "فالوور"; ?>
		</li>
		<li class="transaction_price">قیمت: <?= $transaction->price ?> تومان</li>
		<li class="transaction_amount">مقدار: <?= $transaction->amount ?></li>
		<li class="transaction_authority">تراکنش: <?= $transaction->authority ?></li>
		<li class="transaction_fallback_url"><a href="<?= $full_fallback_url ?>">آدرس جهت دریافت اطلاعات</a></li>
	</ul>

	<div class="spinner fetch_spinner">
	  <div class="rect1"></div>
	  <div class="rect2"></div>
	  <div class="rect3"></div>
	  <div class="rect4"></div>
	  <div class="rect5"></div>
	</div>
	<p class="fetch_loading_text"><?= __( 'درحال بارگذاری اطلاعات ...', 'barhanmedia' ); ?></p>

	<!-- CSV Download Links -->
	<div id="csv_links" style="display: none;"></div>
</div>

<!-- Random Table -->
<div id="random_table" style="display: none;">
	<h2>لیست برنده های قرعه کشی</h2>
</div>





<?php 
$method 		= $transaction->method;
$amount 		= $transaction->amount;
$input  		= $transaction->input;
$random_amount  = $transaction->random_amount;
include_once(plugin_dir_path( __FILE__ ) . 'fetch_script.php');	

endif; // Transaction Validation
endif; // Login Validation
?>