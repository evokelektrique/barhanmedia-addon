<?php $item = BarhanMediaSubscribesFunctions::get_subscribe($data['id']); ?>

<div class="wrap">
	<h2 class="barhanmedia_heading">
		نمایش کاربر (<?= $item->first_name ?>)
		<a class="add-new-h2" href="<?php menu_page_url( 'barhanmedia' ); ?>">برگشت</a>
	</h2>
	<div class="barhanmedia_wrapper">
		<ul>
			<li> <span>آیدی</span> <?= $item->id ?> </li>
			<li> <span>نام</span> <?= $item->first_name ?> </li>
			<li> <span>نام خوانوادگی</span> <?= $item->last_name ?> </li>
			<li> <span>شماره همراه</span> <?= $item->phone ?> </li>
			<li> <span>آدرس صفحه اینستاگرام</span> <?= $item->instagram_page_address ?> </li>
		</ul>
	</div>
</div>