<?php

/*
Plugin Name: افزونه برهان مدیا
Description: اضافه کردن ویژگی و قابلیت های جدید
Author: EVOKE
Version: 1.1
Author URI: https://github.com/evokelektrique
Text Domain: barhanmedia
*/

require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
use Phpfastcache\Helper\Psr16Adapter;
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

class BarhanMedia {

    private static $instance;
	public static $version = '1.1';

	// Construction
	public function __construct() {
		// Call Load Files
		$this->load_files();
	}

	// Get Instance Method
    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get Version
	public static function get_version() {
		return self::$version;
	}

	// Installation Method
	public static function installation() {
		// Call Database Installtion Method
		BarhanMediaFunctions::installation();
	}

	// Deactivation
	public static function deactivation() {
		// ...
	}

	// Include Files
	private function load_files() {

		// Constatns
		include_once(plugin_dir_path( __FILE__ ).'constants.php');

		// Funtions
		include_once(plugin_dir_path( __FILE__ ).'functions.php');

		// Hooks
		include_once(plugin_dir_path( __FILE__ ).'hooks.php');

		// Seasons Table Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/seasons/seasons_table_class.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/seasons/seasons_table_functions.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/seasons/seasons_table_form_handler_class.php');

		// Subscribes Table Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/subscribes/subscribes_table_class.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/subscribes/subscribes_table_functions.php');

		// Sponsors Table Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/sponsors/sponsors_table_class.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/sponsors/sponsors_table_functions.php');
		// Sponsors Form Handler Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/sponsors/sponsors_table_form_handler_class.php');

		// Plans Table Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/plans/plans_table_class.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/plans/plans_table_functions.php');
		// Plans Form Handler Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/plans/plans_table_form_handler_class.php');

		// Transactions Table Class
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/transactions/transactions_table_class.php');
		include_once(plugin_dir_path( __FILE__ ).'includes/tables/transactions/transactions_table_functions.php');

	}

	public static function login_to_instagram() {
		$username = get_option( 'instagram_username' );
		$password = get_option( 'instagram_password' );

		if($username !== false && $password !== false) {
			// Login into account
			$instagram = \InstagramScraper\Instagram::withCredentials(
				new Client(),
				$username, 
				$password, 
				new Psr16Adapter('Files', new ConfigurationOption([
                    'path' => __DIR__.'/cache',
                ]))
			);
			$instagram->login();
			$instagram->saveSession();
			sleep(2); // Delay to mimic user
			return $instagram;
		} else {
			return null;
		}
	}

	public static function get_by_username($instagram, $username) {
		$account = $instagram->getAccount($username);
		return $account;
	}

	public static function get_followers($instagram, $account_id) {
		$followers = [];
		sleep(2);
		$followers = $instagram->getFollowers($account_id, 100, 1, true);
		return $followers;
	}
	
	public static function get_followings($instagram, $account_username, $total=200, $chunk=100) {
		$account = $instagram->getAccount($account_username);
		$followings = [];
		$followings = $instagram->getFollowing($account->getId(), $total, $chunk, true);
		return $followings;
	}
	
	public static function get_media_likes($instagram, $code) {
		$likes = $instagram-> getMediaLikesByCode($code);
		return $likes;
	}

	// Retrieves given instagram media/post details by its URL
	public static function get_media_by_url($instagram, $input) {
		try {
			// Fetch media details
			$media = $instagram->getMediaByUrl((string)$input);
			return [
				'status' 		 => true,
				'message' 		 => null,
				'id' 			 => $media->getId(),
				'type' 			 => $media->getType(),
				'shortcode' 	 => $media->getShortCode(),
				'image' 		 => $media->getImageHighResolutionUrl(),
				'caption' 		 => $media->getCaption(),
				'comments_count' => $media->getCommentsCount(),
				'likes_count'    => $media->getLikesCount(),
				'created_at' 	 => $media->getCreatedTime(),
			];
		} catch (\Exception $e) {
			return [
				'status' => false,
				'message' => $e,
			];
		}
	}

	// Retrieves given instagram account details by its USERNAME
	public static function get_account($instagram, $input) {
		try {
			// Fetch media details
			$account = $instagram->getAccount((string)$input);
			if(!$account->isPrivate()) {
				return [
					'status' 		 => true,
					'message' 		 => null,
					'id' 			 => $account->getId(),
					'username' 		 => $account->getUsername(),
					'full_name' 	 => $account->getFullName(),
					'biography' 	 => $account->getBiography(),
					'media_count' 	 => $account->getMediaCount(),
					'followers_count'=> $account->getFollowsCount(),
					'follows_count'  => $account->getFollowedByCount(),
					'is_private' 	 => $account->isPrivate(),
					'is_verified' 	 => $account->isVerified(),
				];
								
				// biography: "Co-founder, former CEO of @instagram"
				// followers_count: 531
				// follows_count: 7852751
				// full_name: "Kevin Systrom"
				// id: 3
				// is_private: false
				// is_verified: true
				// media_count: 1515
				// message: null
				// status: true
				// username: "kevin"

			} else {
				return [
					'status' => false,
					'message' => __('Account is private, Please provide a valid username.', 'barhanmedia'),
				];
			}
		} catch (\Exception $e) {
			return [
				'status' => false,
				'message' => $e,
			];
		}
	}
}

$barhanmedia = BarhanMedia::get_instance();
$GLOBALS['barhanmedia'] = $barhanmedia;
