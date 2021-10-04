<?php
global $wpdb;
$season = BarhanMediaSeasonsFunctions::get_season($arguments['id']);
if($season->status):
if(isset($_GET['subscribe_submit'])):
	extract($_GET);

	if(!empty($phone) and 
		!empty($first_name) and 
		!empty($last_name) and 
		!empty($instagram_page_address)):
		$subscribes_table_name = $wpdb->prefix . 'barhanmedia_subscribes';
		$subscribe = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_subscribes WHERE phone = %d AND instagram_page_address = %s', $phone, $instagram_page_address ) );

		if(empty($subscribe)):
			$sponsors = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'barhanmedia_sponsors');
			$instagram = BarhanMedia::login_to_instagram();
			$followings = BarhanMedia::get_followings($instagram, $instagram_page_address, 200, 100);
			foreach($sponsors as &$sponsor) {
				$sponsor_key = array_search($sponsor->page_username, array_column($followings['accounts'], 'username'));
				if($sponsor_key === false) {
					echo "لطفا تمامی اسپاسنر ها را فالو کنید !";
					break;					
				}
			}


			$token = round(rand(10000000,99999999));
			$fields = [
				'phone' => $phone,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'instagram_page_address' => $instagram_page_address,
				'token' => $token,
				'season_id' => $season_id,
				'created_at' => current_time( 'mysql' ),
			];
			$wpdb->insert($subscribes_table_name, $fields);
		?>
			Successfully Subscribed ! - <?= $token ?>
		<?php else: ?>
			Already Subscribed ! - <?= $subscribe->token ?>
		<?php endif; ?>
	<?php else: ?>
		Fill inputs please
	<?php endif; ?>
<?php endif; ?>




<form method="GET" action="" accept="UTF-8" class="subscribe_form">
	<label id="subscribe_phone"><?= __('شماره همراه', PLUGIN_NAME) ?></label>
	<input type="text" id="subscribe_phone" name="phone">

	<label id="subscribe_first_name"><?= __('نام', PLUGIN_NAME) ?></label>
	<input type="text" id="subscribe_first_name" name="first_name">

	<label id="subscribe_last_name"><?= __('نام خانوادگی', PLUGIN_NAME) ?></label>
	<input type="text" id="subscribe_last_name" name="last_name">

	<label id="subscribe_instagram_page_address"><?= __('آدرس صفحه اینستاگرم', PLUGIN_NAME) ?></label>
	<input type="text" id="subscribe_instagram_page_address" name="instagram_page_address">
	<input type="hidden" name="season_id" value="<?= $arguments['id'] ?>">

	<input type="submit" value="<?= __('ثبت نام', PLUGIN_NAME) ?>" id="subscribe_submit" name="subscribe_submit">
</form>

<?php else: ?>
	Season Disabled
<?php endif ?>
