<?php $item = BarhanMediaTransactionsFunctions::get_transaction($data['id']); ?>

<div class="wrap">
	<h2 class="barhanmedia_heading">
		<a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
	</h2>
	<div class="barhanmedia_wrapper">
		<?php var_dump($item) ?>
	</div>
</div>