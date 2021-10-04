<?php 
if(is_user_logged_in()):
$nonce = wp_create_nonce('submit_form');
?>

<!-- Methods -->
<div id="barhanmedia_methods">
	<select id="barhanmedia_instagram_embeded_method">
		<option value="like"><?= __('لایک', 'barhanmedia') ?></option>
		<option value="comment"><?= __('کامنت', 'barhanmedia') ?></option>
		<option value="follower"><?= __('فاللور', 'barhanmedia') ?></option>
	</select>
</div>

<div>
	<!-- Phone -->
	<label for="phone">شماره همراه:</label>
	<input type="text" id="phone" placeholder="مثال: 9010000000">
	<br>
	<!-- Random Unit -->
	<label for="random_amount">مقدار انتخاب تصادفی:</label>
	<input type="number" min="1" value="1" id="random_amount" placeholder="1">
</div>

<!-- Media -->
<div id="submit_media_form">
	<label for="input_media_url">آدرس پست:</label>
	<input type="text" id="input_media_url">
	<br>
</div>

<!-- Profile -->
<div id="submit_profile_form" style="display: none">
	<label for="input_profile_username">آدرس  پروفایل:</label>
	<input type="text" id="input_profile_username">
	<br>
</div>

<div>
	<button data-nonce="<?=$nonce?>" id="submit_button"></button>
</div>

<!-- Price -->
<div id="barhanmedia_calculated_plan" style="display: none;">
	<div class="overlay_loader">
		<div class="spinner">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>
	</div>

	<div id="barhanmedia_calculated_plan_content" style="display: none;">
		<h3 id="barhanmedia_calculated_plan_price"></h3>
		<p id="barhanmedia_calculated_plan_description"></p>
		
		<button data-nonce="<?= wp_create_nonce('submit_purchase') ?>" id="barhanmedia_calculated_plan_purchase_button">
			<?= __('خرید', 'barhanmedia') ?>	
		</button>
	</div>
</div>
<?php else: ?>
	<?php BarhanMediaFunctions::not_logged_in_template() ?>
<?php endif; ?>