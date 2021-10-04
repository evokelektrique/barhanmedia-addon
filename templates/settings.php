<?php 

$default_instagram_username = get_option( 'instagram_username' );
$default_instagram_password = get_option( 'instagram_password' );
$default_merchant_id 		= get_option( 'merchant_id' );
$default_verify_page 		= get_option( 'verify_page' );
$default_fallback_page 		= get_option( 'fallback_page' );
$default_email_subject_text = get_option( 'email_subject_text' );
$default_email_message_text = get_option( 'email_message_text' );
$pages = get_pages(); 

if(isset($_POST['submit_settings'])):
	/*
	exctracts:
		$instagram_username
		$instagram_password
		$marchant_id
		$verify_page
		$fallback_page
	*/
	extract($_POST);

	$username_option = 'instagram_username' ;
	$password_option = 'instagram_password' ;

	if ( get_option( $username_option ) !== false ) {
	    update_option( $username_option, $instagram_username );
	} else {
	    add_option( $username_option, $instagram_username );
	} 

	if ( get_option( $password_option ) !== false ) {
	    update_option( $password_option, $instagram_password );
	} else {
	    add_option( $password_option, $instagram_password );
	}

	if ( get_option( 'merchant_id' ) !== false ) {
	    update_option( 'merchant_id', $merchant_id );
	} else {
	    add_option( 'merchant_id', $merchant_id );
	} 	

	if ( get_option( 'verify_page' ) !== false ) {
	    update_option( 'verify_page', $verify_page );
	} else {
	    add_option( 'verify_page', $verify_page );
	} 	

	if ( get_option( 'fallback_page' ) !== false ) {
	    update_option( 'fallback_page', $fallback_page );
	} else {
	    add_option( 'fallback_page', $fallback_page );
	} 	

	if ( get_option( 'email_subject_text' ) !== false ) {
	    update_option( 'email_subject_text', $email_subject_text );
	} else {
	    add_option( 'email_subject_text', $email_subject_text );
	} 

	if ( get_option( 'email_message_text' ) !== false ) {
	    update_option( 'email_message_text', $email_message_text );
	} else {
	    add_option( 'email_message_text', $email_message_text );
	} 	
?>
<h3 style="color:green; font-family: tahoma">تنظیمات با موفقیت ثبت شد</h3>
<?php endif; ?>


<form method="POST" action="" accept="UTF-8" class="settings_form">

	<h2 class="barhanmedia_heading">حساب کاربری اینستاگرام</h2>
			<hr>
	<table>
		<tr>
			<th>
				<label for="instagram_username"><?= __('نام کاربری', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<input value="<?= $default_instagram_username ?>" type="text" id="instagram_username" name="instagram_username">
			</td>
		</tr>	
		<tr>
			<th>
				<label for="instagram_password"><?= __('رمز عبور', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<input value="" type="password" id="instagram_password" name="instagram_password">
				<?= ($default_instagram_password !== false && !empty($default_instagram_password)) ? '<b>نکته:</b> پسورد ثبت شده است اما به دلایل امنیتی نشان داده نمی شود.' : 'لطفا رمز عبوری جهت استفاده از اینستاگرام وارد نمایید، در غیر اینصورت به مشکل مواجه می شوید.' ?>
			</td>
		</tr>		
		<tr>
			<th>
				<label for="merchant_id"><?= __('کد API درگاه پرداخت', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<input value="<?= $default_merchant_id ?>" type="text" id="merchant_id" name="merchant_id">
				<?= $default_merchant_id === false ? '<b>هشدار:</b>لطفا کد API درگاه پرداخت زرین پال خود را وارد نمایید در غیر این صورت به مشکل مواجه می شوید.' : '' ?>
			</td>
		</tr>

		<tr>
			<th>
				<label for="email_subject_text"><?= __('متن عنوان ایمیل', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<input value="<?= $default_email_subject_text ?>" type="text" id="email_subject_text" name="email_subject_text">
			</td>
		</tr>

		<tr>
			<th>
				<label for="email_message_text"><?= __('متن پیام ایمیل', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<input value="<?= $default_email_message_text ?>" type="text" id="email_message_text" name="email_message_text">
			</td>
		</tr>

		<tr>
			<th>
				<label for="verify_page"><?= __('صفحه فرود تایید پرداخت', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<select name="verify_page">
					<option><?php echo esc_attr( __( 'انتخاب صفحه' ) ); ?></option>
					<?php 
					foreach ( $pages as $page ) {
						$option = '<option '. ($default_verify_page === get_page_link( $page->ID ) ? 'selected' : '') .' value="' . get_page_link( $page->ID ) . '">';
						$option .= $page->post_title;
						$option .= '</option>';
						echo $option;
					}
					?>
				</select>
				<?= ($default_verify_page === false) ? '<b>هشدار:</b> لطفا صفحه ای را جهت تایید پرداخت انتخاب کنید' : '' ?>
			</td>
		</tr>		
		<tr>
			<th>
				<label for="fallback_page"><?= __('صفحه دریافت', PLUGIN_NAME) ?></label>
			</th>
			<td>
				<select name="fallback_page">
					<option><?php echo esc_attr( __( 'انتخاب صفحه' ) ); ?></option>
					<?php 
					foreach ( $pages as $page ) {
						$option = '<option '. ($default_fallback_page === get_page_link( $page->ID ) ? 'selected' : '') .' value="' . get_page_link( $page->ID ) . '">';
						$option .= $page->post_title;
						$option .= '</option>';
						echo $option;
					}
					?>
				</select>
				<?= ($default_fallback_page === false) ? '<b>هشدار:</b> لطفا صفحه ای را انتخاب کنید' : '' ?>
			</td>
		</tr>
	</table>
	<br>

    <?php wp_nonce_field( '' ); ?>
    <?php submit_button( __( 'ثبت تنظیمات', 'barhanmedia' ), 'primary', 'submit_settings' ); ?>
</form>