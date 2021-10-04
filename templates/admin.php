<div class="wrap">
	<h2 class="barhanmedia_heading">
		برهان مدیا
	</h2>

	<div class="barhanmedia_dashboard">
	
		<div class="d-flex">
			<div class="flex-1">
				<div class="box m-3 p-3">
					<div class="box_content">
					<span class="box_content_details">
						این هفته: <?= count(BarhanMediaSubscribesFunctions::get_all_subscribers()); ?>
							<br>
						این ماه: <?= count(BarhanMediaSubscribesFunctions::get_all_subscribers('-1 month')); ?>
					</span>

						<h3>
							<?= BarhanMediaSubscribesFunctions::get_subscribe_count(); ?>
						</h3>
					</div>
					<h3>
						<?= __('تعداد شرکت کنندگان', PLUGIN_NAME) ?>
						<br>
					</h3>
				</div>
			</div>
			<div class="flex-1">
				<div class="box m-3 p-3">
					<div class="box_content">
						<h3>
							<?= BarhanMediaSponsorsFunctions::get_sponsor_count(); ?>
						</h3>
					</div>
					<h3>
						<?= __('تعداد اسپانسر ها', PLUGIN_NAME) ?>
					</h3>
				</div>
			</div>
		</div>
	</div>
</div>
