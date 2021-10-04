<?php if(is_user_logged_in()): ?>

<script type="text/javascript">
jQuery(document).ready(function() {
	const data = {
		'action'	   : 'fetch',
		'method'	   : '<?= $method ?>',
		'amount'	   : '<?= $amount ?>',
		'input' 	   : '<?= $input ?>',
		'random_amount': '<?= $random_amount ?>',
		'fallback_url' : '<?= $transaction_id ?>',
	}

	jQuery.post(settings.ajaxurl, data, function(response) {
		if(response.success) {

			// Tune Wrappers
			jQuery("#csv_links").show();
			jQuery(".fetch_loading_text").hide();
			jQuery(".fetch_spinner").hide();

			// Links
			const files = response.data;

			// Full CSV Link
			const full_csv = jQuery('<a/>', {
				class: 'full_csv_download_link',
				text: 'دریافت لیست کل',
				href: files.full_csv
			})
			.appendTo(jQuery('#csv_links'));

			// Random CSV Link
			const random_csv = jQuery('<a/>', {
				class: 'random_csv_download_link',
				text: 'دریافت لیست قرعه کشی',
				href: files.random_csv
			})
			.appendTo(jQuery('#csv_links'));

			// Generate Random Table
			var table = "<table>";
			console.log(response.data.random_items);
			Array.from(response.data.random_items).forEach(function(item) {
				table += '<tr><td>' + item.id + '</td><td>' + item.username + '</td></tr>';
			});
			table += "</table>";
			jQuery("#random_table").append(table);
			jQuery("#random_table").show();

		}
	});
});
</script>

<?php endif; ?>
