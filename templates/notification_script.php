<script> 
(function($) {
	$(document).ready(function() {
		const data = {
			'action'			: 'send_notification',
			'full_fallback_url'	: '<?= $full_fallback_url ?>',
			'phone' 			: '<?= $phone ?>',
			'authority'			: '<?= $authority ?>',
		};
		
		$.post(settings.ajaxurl, data, function(response) {
			console.log(response);
			if(response.success) {
				// Wait 5 seconds
				setTimeout(function() {
					// Redirect to proccess
					window.location = '<?= $full_fallback_url ?>';
				}, 5000);
			}
		});
	});
})(jQuery);
</script>