<?php $item = BarhanMediaSponsorsFunctions::get_sponsor($data['id']); ?>

<div class="wrap">
	<h2 class="barhanmedia_heading">
		مشاهده صفحه (<?= $item->page_full_name ?>)
		<a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
	</h2>
	<div class="barhanmedia_wrapper">
		<?php var_dump($item) ?>

<?php 
$account_id = $item->page_id;
$instagram = BarhanMedia::login_to_instagram();
$followers = BarhanMedia::get_followers($instagram, $account_id);
var_dump($followers);
?>		
	</div>
</div>