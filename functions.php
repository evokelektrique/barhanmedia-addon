<?php

// 
// Functions
// 
class BarhanMediaFunctions {

	// Installation
	public static function installation() {
		// Require wordpress db
		global $wpdb;

		// Require wordpress dbDelta
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// Seasons Table
		$seasons_table_sql 				= self::generate_seasons_table($wpdb);

		// Subscribes Table
		$subscribes_table_sql 			= self::generate_subscribes_table($wpdb);

		// Sponsors Table
		$sponsors_table_sql 			= self::generate_sponsors_table($wpdb);

		// Sponsor Followers Table
		$sponsor_followers_table_sql 	= self::generate_sponsor_followers_table($wpdb);

		// Plans Table
		$plans_table_sql 				= self::generate_plans_table($wpdb);

		// Transactions Table
		$transactions_table 			= self::generate_transactions_table($wpdb);

		// Files Table
		$files_table 					= self::generate_files_table($wpdb);

		// Generate Tables
		dbDelta( $seasons_table_sql );
		dbDelta( $subscribes_table_sql );
		dbDelta( $sponsors_table_sql );
		dbDelta( $sponsor_followers_table_sql );
		dbDelta( $plans_table_sql );
		dbDelta( $transactions_table );
		dbDelta( $files_table );
	}

	// Schema Of Seasons Table
	protected static function generate_seasons_table($wpdb) {
		// Register Table Name
		$seasons_table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'seasons';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $seasons_table_name (
			`id` BIGINT unsigned NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
			`status` BOOLEAN DEFAULT '1',
			`created_at` TIMESTAMP COMMENT 'Created at Date',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Subscribes Table
	protected static function generate_subscribes_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'subscribes';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` BIGINT unsigned NOT NULL AUTO_INCREMENT,
			`season_id` BIGINT unsigned NOT NULL,
			`token` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL COMMENT 'Random Token Given To User',
			`phone` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL COMMENT 'Phone Number',
			`first_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL COMMENT 'First Name',
			`last_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL COMMENT 'Last Name',
			`instagram_page_address` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL COMMENT 'Instagram Page Address',
			`created_at` TIMESTAMP COMMENT 'Created at Date',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Sponsors Table
	protected static function generate_sponsors_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'sponsors';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` BIGINT unsigned NOT NULL AUTO_INCREMENT,
			`season_id` BIGINT unsigned NOT NULL,
			`page_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Id',
			`page_username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Username',
			`page_full_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Full name',
			`page_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Biography',
			`page_picture` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Profile picture url',
			`is_private` BOOLEAN DEFAULT '0' COMMENT 'Is private',
			`is_verified` BOOLEAN DEFAULT '0' COMMENT 'Is verified',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Sponsor Followers Table
	protected static function generate_sponsor_followers_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'sponsor_followers';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` INT unsigned NOT NULL AUTO_INCREMENT,
			`sponsor_id` BIGINT unsigned,
			`user_id` BIGINT unsigned,
			`user_username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
			`user_full_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
			`user_profile` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
			`is_verified` BOOLEAN DEFAULT '0',
			`followed_by_viewer` BOOLEAN DEFAULT '0',
			`requested_by_viewer` BOOLEAN DEFAULT '0',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Plans Table
	protected static function generate_plans_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'plans';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` INT unsigned NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
			`type` ENUM('like', 'comment', 'follower') CHARACTER SET utf8 COLLATE utf8_persian_ci,
			`amount` BIGINT unsigned NOT NULL,
			`price` BIGINT unsigned NOT NULL,
			`created_at` TIMESTAMP,
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Transactions Table
	protected static function generate_transactions_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'transactions';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` BIGINT unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
			`user_id` BIGINT unsigned NOT NULL COMMENT 'User Unique Identifier',
			`price` BIGINT unsigned COMMENT 'Purchase Price',
			`method` ENUM('like', 'comment', 'follower') CHARACTER SET utf8 COLLATE utf8_persian_ci,
			`amount` INT COMMENT 'Amount of unit',
			`random_amount` BIGINT unsigned DEFAULT '1' COMMENT 'Random picks unit',
			`phone` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Phone Number',
			`authority` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Zarinpal Authority Code',
			`input` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Media/Account IG Url',
			`fallback_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Fall Back Url' DEFAULT NULL,
			`full_csv_status` BOOLEAN DEFAULT '0' COMMENT 'Full CSV Generated File Status',
			`random_csv_status` BOOLEAN DEFAULT '0' COMMENT 'Random CSV Generated File Status',
			`status` BOOLEAN DEFAULT '0' COMMENT 'Purchase Status',
			`created_at` TIMESTAMP COMMENT 'Created at Date',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Schema Of Files Table
	protected static function generate_files_table($wpdb) {
		// Register Table Name
		$table_name = $wpdb->prefix . PLUGIN_NAME . '_' . 'files';
		// Register Table Charset
		$charset_collate = $wpdb->get_charset_collate();
		// SQL Query
		return "CREATE TABLE $table_name (
			`id` BIGINT unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier',
			`user_id` BIGINT unsigned NOT NULL COMMENT 'User Unique Identifier',
			`url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'File URL',
			`type` ENUM('random', 'full') CHARACTER SET utf8 COLLATE utf8_persian_ci,
			`fallback_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci COMMENT 'Fall Back Url/UUID' DEFAULT NULL,
			`created_at` TIMESTAMP COMMENT 'Created at Date',
			PRIMARY KEY (`id`)
		) $charset_collate;";
	}

	// Admin Menu
	public static function admin() {
		// Top Menu
		add_menu_page(
			__( 'برهان مدیا عنوان', PLUGIN_NAME ),
			__( 'برهان مدیا', PLUGIN_NAME ),
			'manage_options',
			'barhanmedia',
			'BarhanMediaFunctions::admin_page_template',
			plugins_url('barhanmedia-addon/icon.png'),
			3
		);

		// Seasons Menu
		add_submenu_page( 
			'barhanmedia',
			__('فصل ها عنوان', PLUGIN_NAME),
			__('فصل ها', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-seasons',
			'BarhanMediaFunctions::admin_seasons_template'
		);

		// Sponsors Menu
		add_submenu_page( 
			'barhanmedia',
			__('اسپانسر ها', PLUGIN_NAME),
			__('اسپانسر ها', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-sponsors',
			'BarhanMediaFunctions::admin_sponsors_template'
		);

		// Subscribes Menu
		add_submenu_page( 
			'barhanmedia',
			__('شرکت کنندگان', PLUGIN_NAME),
			__('شرکت کنندگان', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-subscribes',
			'BarhanMediaFunctions::admin_subscribes_template'
		);

		// Plans Menu
		add_submenu_page( 
			'barhanmedia',
			__('پلن ها', PLUGIN_NAME),
			__('پلن ها', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-plans',
			'BarhanMediaFunctions::admin_plans_template'
		);

		// Transactions Menu
		add_submenu_page( 
			'barhanmedia',
			__('تراکنش ها', PLUGIN_NAME),
			__('تراکنش ها', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-transactions',
			'BarhanMediaFunctions::admin_transactions_template'
		);

		// Settings Menu
		add_submenu_page( 
			'barhanmedia',
			__('تنظیمات', PLUGIN_NAME),
			__('تنظیمات', PLUGIN_NAME),
		    'manage_options',
			'barhanmedia-settings',
			'BarhanMediaFunctions::admin_settings_template'
		);
	}

	public static function admin_page_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/admin.php');
	}

	public static function admin_seasons_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/seasons.php');
	}

	public static function admin_subscribes_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/subscribes.php');
	}

	public static function admin_sponsors_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/sponsors.php');
	}

	public static function admin_plans_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/plans.php');
	}

	public static function admin_transactions_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/transactions.php');
	}

	public static function admin_settings_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/settings.php');
	}

	public static function fetch_template() {
		require_once(plugin_dir_path( __FILE__ ).'templates/fetch.php');
	}

	// Register style & scripts
	public static function register_styles($hook) {
		// Plugin Style
		wp_register_style( 'style', plugins_url( PLUGIN_DIR_NAME . '/assets/css/style.css' ) );
		wp_enqueue_style( 'style' );

		// jQuery
		// wp_deregister_script('jquery');
		// wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', [], null, true);

		// Plugin Js
		wp_register_script( 'script', plugins_url( PLUGIN_DIR_NAME . '/assets/js/script.js' ), ['jquery'], null, true);
		wp_enqueue_script( 'script' );

		// Set javascript objects
		wp_localize_script( 'script', 'settings', [
			'ajaxurl' 			=> admin_url('admin-ajax.php'),
		    'error'   			=> __( 'متاسفانه مشکلی پیش آمده، لطفا دوباره تلاش کنید.', 'barhanmedia' ),
		    'sending_label' 	=> 'درحال دریافت...',
		    'sent_label' 		=> 'دریافت شد',
		    'redirect_purchase' => 'درحال انتقال...',
		    'embed_link_text' 	=> 'آدرس پست',
		    'submit_profile' 	=> __('تایید پروفایل', 'barhanmedia'),
			'submit_media' 		=> __('تایید پست', 'barhanmedia'),
		]);
	}


	public static function subscribe_form($arguments = []) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/subscribe_form.php');
	}

	public static function submit_form_template($arguments = []) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/submit_form.php');
	}

	public static function verify_purchase_template($arguments = [], $content = null) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/verify_purchase.php');
	}

	public static function successful_purchase_template($arguments = [], $content = null) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/successful_purchase.php');
	}

	public static function failed_purchase_template($arguments = [], $content = null) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/failed_purchase.php');
	}

	public static function not_logged_in_template() {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/not_logged_in.php');
	}

	public static function get_plan() {
		$data = $_POST;
		$type = sanitize_text_field( $data['type'] );
		$amount = intval($data['amount']);
		$plan = BarhanMediaPlansFunctions::get_plan_by_type( $type, $amount );

		if(!empty($plan)) {
			wp_send_json_success($plan);
		} else {
			wp_send_json_error(__('مشکلی رخ داد، مجددا تلاش کنید', 'barhanmedia'));
		}
	}

	// Retrieve media url and send the results by ajax
	public static function submit_form() {
		// Incomming Post Data
		$data = $_POST;

		// Check Nonce & Check Request Referer
		if(check_ajax_referer('submit_form', 'nonce', true) === false) {
			wp_send_json_error(__('مشکلی رخ داد، مجددا تلاش کنید', 'barhanmedia'));
		}

		$type 		= sanitize_text_field( $data['type'] );
		$instagram  = BarhanMedia::login_to_instagram();
		$input 		= $data['input'];

		if($type === 'profile') {
			$response = BarhanMedia::get_account($instagram, $input);
		} else {
			$response = BarhanMedia::get_media_by_url($instagram, $input);
		}

		// Response
		if(!empty($response)) {
			wp_send_json_success($response);
		} else {
			wp_send_json_error(
				__(
					'مشکلی رخ داد، مجددا تلاش کنید.',
					'barhanmedia'
				)
			);
		}

		// // Email Configurations
		// $admin_email = get_option( 'admin_email' );
		// $subject 	 = '';
		// $message 	 = '';

		// // Send Email
		// wp_mail( $admin_email, $subject, $message );
	}


	public static function submit_purchase() {
		// Incomming Post Data
		$data = $_POST;

		// Check Nonce & Check Request Referer
		if(check_ajax_referer('submit_purchase', 'nonce', true) === false || is_user_logged_in() === false) {
			wp_send_json_error(__('مشکلی رخ داد، مجددا تلاش کنید', 'barhanmedia'));
		}

		$method 		= sanitize_text_field( $data['method'] );
		$input 			= $data['input'];
		$amount 		= intval($data['amount']);
		$random_amount 	= $data['random_amount'];
		$plan 			= BarhanMediaPlansFunctions::get_plan_by_type( $method, $amount );

		// $instagram  = BarhanMedia::login_to_instagram();
		// if($type === 'profile') {
		// 	$item = BarhanMedia::get_account($instagram, $input);
		// } else {
		// 	$item = BarhanMedia::get_media_by_url($instagram, $input);
		// }

		$merchant_id 	= get_option( 'merchant_id' );
		$amount 		= intval($plan->price);
		$description 	= 'توضیحات تراکنش تستی';
		$mobile 		= sanitize_text_field( $data['phone'] );
		$callback_url 	= get_option( 'verify_page' );

		// Get current user
		$current_user = wp_get_current_user();

		$client = new SoapClient(
			'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 
			['encoding' => 'UTF-8']
		);

		$result = $client->PaymentRequest([
			'MerchantID' => $merchant_id,
			'Amount' 	 => $amount,
			'Description'=> $description,
			'Email' 	 => !empty($current_user->user_email) ? $current_user->user_email : '',
			'Mobile' 	 => $mobile,
			'CallbackURL'=> $callback_url,
		]);

		// Response
		if ($result->Status == 100) {

			// Put authority in session in case if needed for verification
			$_SESSION['authority'] = $result->Authority;
			$transaction_fields = [
				'price' 		=> $amount,
				'user_id' 		=> $current_user->ID,
				'method' 		=> $method,
				'amount' 		=> $plan->amount,
				'authority' 	=> $result->Authority,
				'input' 		=> $input,
				'phone' 		=> $mobile,
				'random_amount' => $random_amount,
				'status' 		=> 0
			];
			$transaction_id = BarhanMediaTransactionsFunctions::insert_transaction($transaction_fields);
			if(is_wp_error( $transaction_id )) {
				wp_send_json_error( $result->Status );
			} else {
				wp_send_json_success([
					'status' => true,
					'message' => null,
					'redirect_url' => 'https://sandbox.zarinpal.com/pg/StartPay/'.$result->Authority,
				]);
			}
		} else {
			wp_send_json_error( $result->Status );
		}

	}

	public static function send_notification() {
		$data = $_POST;
		$full_fallback_url = $data['full_fallback_url'];
		$current_user = wp_get_current_user();

		// Email Configurations
		$subject 	 	 = get_option( 'email_subject_text' );
		$default_message = "\nلینک جهت دریافت اطلاعات تراکنش و فایل: $full_fallback_url";
		$message 	 	 = get_option( 'email_message_text' ) . $default_message;
		// Send Email
		$email = wp_mail( $current_user->user_email, $subject, $message );
		if(is_wp_error( $email )) {
			wp_send_json_error(['status' => false, 'email' => false]);
		}

		// SMS Configuration
		$user_phone = $data['phone'];
		$sms_message = "لینک جهت دریافت اطلاعات تراکنش و فایل:\n$full_fallback_url";
		// Send SMS
		//// IPPanel
		// $sms = wp_remote_get( "http://ippanel.com/class/sms/webservice/send_url.php?from=3000505&to=$user_phone&msg=$sms_message&uname=baazarcheh&pass=s12645navid" );
		//// New panel? idk
		$sms = wp_remote_get( "http://htpsms.ir/send_via_get/send_sms.php?username=borhan&password=pedram10300&sender_number=500022200222&receiver_number=$user_phone&note=$sms_message" );

		if(is_wp_error( $sms )) {
			wp_send_json_error(['status' => false, 'sms' => false]);
		}

		// Response
		wp_send_json_success([ 'status' => true, 'email' => true, 'sms' => true ]);
	}


	public static function get_likes($instagram, $input, $amount) {
		$media = $instagram->getMediaByUrl($input);
		sleep(1);
		$likes_object = $instagram->getMediaLikesByCode($media->getShortCode(), $amount);
		$likes = [];

		foreach($likes_object as &$like) {
			$likes[] = [
				'id' => $like->getId(),
				'username' => $like->getUserName(),
				'full_name' => $like->getFullName(),
				'profile_picture' => $like->getProfilePicUrl(),
			];
		}

		return $likes;
	}

	public static function get_comments($instagram, $input, $amount) {
		$media = $instagram->getMediaByUrl($input);
		sleep(1);
		$comments_object = $instagram->getMediaCommentsByCode($media->getShortCode(), $amount);
		$comments = [];
		foreach($comments_object as &$comment) {
			$owner = $comment->getOwner();
			$comments[] = [
				'id' 					=> $comment->getId(),
				'text' 					=> $comment->getText(),
				'child_comments_count' 	=> $comment->getChildCommentsCount(),
				'created_at' 			=> $comment->getCreatedAt(),
				'owner_id' 				=> $owner->getId(),
				'owner_username' 		=> $owner->getUsername(),
				'owner_profile_picture'	=> $owner->getProfilePicUrlHd()
			];
		}

		return $comments;
	}

	public static function get_followers($instagram, $input, $amount) {
		$account = $instagram->getAccount($input);
		sleep(1);
		$followers_object = $instagram->getFollowers($account->getId(), $amount, 100, true);
		$followers = [];

		foreach($followers_object as &$follower) {
			$followers[] = [
				'id' 			 => $follower['id'],
				'username' 		 => $follower['username'],
				'full_name' 	 => $follower['full_name'],
				'profile_pic_url'=> $follower['profile_pic_url'],
				'is_verified' 	 => $follower['is_verified'],
			];
		}

		return $followers;
	}

	public static function generate_csv($headings = [], $items = "", $custom_filename = "") {
		if(empty($headings) || empty($items)) {
			return null;
		} else {
			$basedir 	= wp_get_upload_dir()['basedir'];
			$baseurl 	= wp_get_upload_dir()['baseurl'];
            $date 		= date("Y-m-d_H-i-s");
			$filename	= !empty($custom_filename) ? $custom_filename : __( 'filename', 'barhanmedia' );
			$fileurl 	= $baseurl."/$filename - $date.csv";
            $output 	= fopen($basedir."/$filename - $date.csv", 'w');
            // UTF-8 Execl
            fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

            // Write Columns
            fputcsv( 
                $output, 
                $headings,
                "\t"
            );

            // Write Rows
            foreach ( $items as $item ) {
                $csv_row = [];
            	foreach($headings as &$heading) {
            		$i = $item[$heading];
            		if($i === true) {
	            		$csv_row[] = __( 'بله', 'barhanmedia' );
            		} elseif($i === false) {
	            		$csv_row[] = __( 'خیر', 'barhanmedia' );
            		} else {
	            		$csv_row[] = $item[$heading];
            		}
            	}
                fputcsv( $output, $csv_row, "\t" );
            }

            fclose($output);
            return $fileurl;
		}
	}

	// Get an RFC-4122 compliant globaly unique identifier
	public static function uuid() {
	    $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
	    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
	    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
	    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}


	// 
	// Ajax Fetch Items
	// 
	public static function fetch() {
		$method 		= $_POST['method'];
		$amount 		= intval($_POST['amount']);
		$input  		= $_POST['input'];
		$random_amount  = intval($_POST['random_amount']);
		$fallback_url  	= $_POST['fallback_url'];

		$current_user 	= wp_get_current_user();

		global $wpdb;

		// Insert Files In DB
		$table_name = $wpdb->prefix . 'barhanmedia_files';

		$full_csv_file = $wpdb->get_row("SELECT * FROM $table_name WHERE fallback_url = '$fallback_url' AND type = 'full' LIMIT 1");
		$random_csv_file = $wpdb->get_row("SELECT * FROM $table_name WHERE fallback_url = '$fallback_url' AND type = 'random' LIMIT 1");

		// In case if files are already generated, 
		// don't need to scrape again and regenerate the files, 
		// just return the previous files.
		if(!empty($full_csv_file) && !empty($random_csv_file)) {
			// Response
			wp_send_json_success([
				'full_csv' 		=> $full_csv_file->url,
				'random_csv' 	=> $random_csv_file->url,
			]);
			exit;
		}

		// Login to Instagram
		$instagram = BarhanMedia::login_to_instagram();

		// Scrapped items from IG
		$items = [];

		// CSV Columns
		$headings = [];

		switch ($method) {
			case 'like':
				$items 		= self::get_likes($instagram, $input, $amount);
				// $headings 	= ['id', 'username', 'full_name', 'profile_picture'];
				$headings 	= ['id', 'username'];
				break;

			case 'follower':
				$items 		= self::get_followers($instagram, $input, $amount);
				// $headings 	= ['id', 'username', 'full_name', 'profile_pic_url', 'is_verified'];
				$headings 	= ['id', 'username'];
				break;

			case 'comment':
				$items 		= self::get_comments($instagram, $input, $amount);
				// $headings 	= ['id', 'text', 'child_comments_count', 'created_at', 'owner_id', 'owner_username', 'owner_profile_picture'];
				$headings 	= ['id', 'username'];
				break;

			default:
				$items = [];
				break;
		}


		if(!empty($items)) {

			// Pick random
			$random_items = [];
			$rand_keys = array_rand($items, $random_amount);
			foreach((array)$rand_keys as &$rand_key) {
				$random_items[] = $items[$rand_key];
			}

			// Generate Random CSV File
			$csv_random_file_url = self::generate_csv(
				$headings, 
				$random_items,
				$current_user->user_login . "_" . $amount . "_" . $method . "_" . "قرعه کشی"
			);

			// Generate Full CSV File
			$csv_file_url 		 = self::generate_csv(
				$headings, 
				$items,
				$current_user->user_login . "_" . $amount . "_" . $method . "_" . "کامل"
			);

			// Validation
			if(!empty($csv_file_url) || !empty($csv_random_file_url)) {

				$defaults = array( 
					'user_id' => $current_user->ID,
					'fallback_url' => $fallback_url,
					'created_at' => current_time( 'mysql' )
				);

				if(empty($full_csv_file)) {
					// Insert Full
					$full_csv_args = wp_parse_args( [
						'url' 	=> $csv_file_url, 
						'type' 	=> 'full'
					], $defaults );
					$wpdb->insert( $table_name, $full_csv_args );
					$wpdb->update( 
						$wpdb->prefix . 'barhanmedia_transactions',
						['full_csv_status' => 1], ['fallback_url' => $fallback_url] 
					);
				}

				if(empty($random_csv_file)) {
					// Insert Random
					$random_csv_args = wp_parse_args( [
						'url' 	=> $csv_random_file_url, 
						'type' 	=> 'random'
					], $defaults );
					$wpdb->insert( $table_name, $random_csv_args );
					$wpdb->update( 
						$wpdb->prefix . 'barhanmedia_transactions', 
						['random_csv_status' => 1], ['fallback_url' => $fallback_url] 
					);
				}

				// Response
				wp_send_json_success([
					'full_csv' 		=> $csv_file_url,
					'random_csv' 	=> $csv_random_file_url,
					'random_items' 	=> $random_items
				]);
			} else {
				// Erro response
				wp_send_json_error( __( 'مشکلی در ایجاد فایل ها پیش آمد، دوباره تلاش کنید', PLUGIN_NAME ));
			}

		} else {
			wp_send_json_error( __( 'موردی یافت نشد', PLUGIN_NAME ));
		}	
	}

	public static function sponsors_list($arguments = []) {
		include_once(plugin_dir_path( __FILE__ ) . 'templates/list_sponsors.php');
	}
}

