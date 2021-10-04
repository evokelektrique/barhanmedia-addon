<?php 
$authority = !empty($_GET['Authority']) ? $_GET['Authority'] : '';
$status = !empty($_GET['Status']) ? $_GET['Status'] : ''; // [OK, NOK]
if ($status === "OK") {
	global $wpdb;
	$table_name = $wpdb->prefix . 'barhanmedia_transactions';
	$fields = ['status' => 1];
	$fetch_status = false;
	$transaction = BarhanMediaTransactionsFunctions::get_transaction($authority);
	if($transaction->status > 0 && !empty($transaction)) {
    	$fetch_status = true;
	} elseif($wpdb->update( $table_name, $fields, array( 'authority' => $authority ) )) {
    	$fetch_status = true;
	} else {
    	$fetch_status = false;
	}

	if($fetch_status) {

		$base_url 					= get_option( 'fallback_page' );
		$uuid 	  					= BarhanMediaFunctions::uuid();
		$transaction_fallback_fields= ['fallback_url' => $uuid];
		$full_fallback_url 			= "$base_url?transaction_id=$uuid";
		$phone 						= $transaction->phone;
		if($wpdb->update( $table_name, $transaction_fallback_fields, array( 'authority' => $authority ) )) {
			echo "تا 5 ثانیه دیگر منتقل میشوید اگر مشکلی رخ داد، ". "<a href='$full_fallback_url'>". 'اینجا' . "</a>"." کلیک کنید";
			include_once(plugin_dir_path( __FILE__ ) . 'notification_script.php');	
		}


	}


}
?>