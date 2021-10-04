(function($) {
	$(document).ready(function() {

		// Initialize
		$('#submit_button').text(settings.submit_media)

		function generate_embeded_instagram_profile(profile) {
			console.log(profile);
		}

		// Generates Custom Instagram Media Embeded By Given Media
		function generate_embeded_instagram_media(media) {
			// Destroy Wrapper
			$('.barhanmedia_instagram_embeded_wrapper').remove();

			// Embed Wrapper
			let embed = $('<div/>', {
				class: "barhanmedia_instagram_embeded_wrapper",
			})
			.appendTo($('#submit_media_form'));

			// High Quality Media Image
			const image = $('<img/>', {
				class: 'barhanmedia_instagram_embeded_image',
				src: media.image, 
			})
			.appendTo($('.barhanmedia_instagram_embeded_wrapper'));

			// Embed Details
			let details = $('<div/>', {
				class: "barhanmedia_instagram_embeded_details",
			})
			.appendTo($('.barhanmedia_instagram_embeded_wrapper'));

			// Media Caption
			const caption = $('<p/>', {
				class: 'barhanmedia_instagram_embeded_caption',
				text: media.caption,
			})
			.appendTo($('.barhanmedia_instagram_embeded_wrapper'));

			// Embed Link
			let link = $('<a/>', {
				class: "barhanmedia_instagram_embeded_link",
				href: `https://www.instagram.com/p/${media.shortcode}/`,
				text: settings.embed_link_text,
			})
			.appendTo($('.barhanmedia_instagram_embeded_wrapper'));

			// Media Likes
			const likes = $('<span/>', {
				class: 'barhanmedia_instagram_embeded_likes_count',
				text: media.likes_count,
			})
			.appendTo($('.barhanmedia_instagram_embeded_details'));
			// Media Likes Icon
			const likes_icon = $('<i/>', {
				class: "fas fa-heart",
			})
			.prependTo($('.barhanmedia_instagram_embeded_likes_count'));

			// Media Comments
			const comments = $('<span/>', {
				class: 'barhanmedia_instagram_embeded_comments_count',
				text: media.comments_count,
			})
			.appendTo($('.barhanmedia_instagram_embeded_details'));
			// Media Comments Icon
			const comments_icon = $('<i/>', {
				class: "fas fa-comment-alt",
			})
			.prependTo($('.barhanmedia_instagram_embeded_comments_count'));


			// Media Created_at Date
			const date = $('<span/>', {
				class: 'barhanmedia_instagram_embeded_date',
				text: new Date(media.created_at * 1e3).toLocaleDateString('fa-IR'),
			})
			.appendTo($('.barhanmedia_instagram_embeded_details'));
			// Media Created_at Icon
			const date_icon = $('<i/>', {
				class: "fas fa-calendar",
			})
			.prependTo($('.barhanmedia_instagram_embeded_date'));
		}

		function get_plan(type, amount) {
			const data = {
				'action': 'get_plan',
				'type'	: type,
				'amount': amount,
			};
			return $.post(settings.ajaxurl, data);
		}

		$('#barhanmedia_instagram_embeded_method').on('change', function(event) {
			event.preventDefault();
			const option = $(this).val();
			console.log(option);
			if(option === 'follower') {
				$('#submit_media_form').hide();
				$('#submit_profile_form').show();
				$('#submit_button').text(settings.submit_profile)
			} else {
				$('#submit_profile_form').hide();
				$('#submit_media_form').show();
				$('#submit_button').text(settings.submit_media)
			}
		});

		// Submit Media
		$('#submit_button').on('click', function(event) {
			event.preventDefault();

			const option 		= $('#barhanmedia_instagram_embeded_method').val();
			const button 		= $(this);
			let input;
			const phone 		= $("#phone");
			const random_amount = $("#random_amount");

			if(option === 'follower') {
				input = $('#input_profile_username');
			} else {
				input = $('#input_media_url');
			}
			
			// Validation
			if(input.val().length === 0) {
				input.css('border', '1px solid red');
				return false;
			} else {
				input.css( 'border', '1px solid green' );
			}
			if(phone.val().length === 0) {
				phone.css('border', '1px solid red');
				return false;
			} else {
				phone.css( 'border', '1px solid green' );
			}
			if(random_amount.val() <= 0 || random_amount.val().length === 0) {
				random_amount.css('border', '1px solid red');
				return false;
			} else {
				random_amount.css( 'border', '1px solid green' );
			}

			// Disable Button
		    button.text(settings.sending_label).prop('disabled', true);

			console.log(option, random_amount.val());
			const data = {
				'action'		: 'submit_form',
				'input'			: input.val(),
				'type'  		: (option === 'follower') ? 'profile' : 'media',
				'nonce'			: button.data('nonce'),
			};

			// Grabs Media/Profile
			$.post(settings.ajaxurl, data, function(response) {
				if(response.success) {
					$('#barhanmedia_calculated_plan').show();
					console.log(response);
					console.log(option);

					// Outputs custom embeded
					if(option == 'follower') {
						generate_embeded_instagram_profile(response.data);
					} else {
						generate_embeded_instagram_media(response.data);
					}

					// Define amount
					let amount;
					switch(option) {
						case 'like':
							amount = response.data.likes_count;
							break;

						case 'comment':
							amount = response.data.comments_count;
							break;

						case 'follower':
							amount = response.data.follows_count;
							break;

						default:
							amount = 0;
							break;
					}

					// Check if option is empty
					if(option === "" || amount === "") {
						return false;
					} else {
						console.log('fetching plan', option, amount);
						// Fetch Plans
						$.when(get_plan(option, amount)).then(function(response) {
							console.log(response);
							const plan = response.data;
							if(response.success === true) {
								$('#barhanmedia_calculated_plan .overlay_loader').hide();
								$('#barhanmedia_calculated_plan_content').show();
								$('#barhanmedia_calculated_plan_price').text(plan.price);
								$('#barhanmedia_calculated_plan_description').text(plan.name);

								// Purchase Action
								$('#barhanmedia_calculated_plan_purchase_button').on('click', function(e) {
									e.preventDefault();

									const option 	= $('#barhanmedia_instagram_embeded_method').val();
									const button 	= $(this);
									let input;

									if(option === 'follower') {
										input = $('#input_profile_username');
									} else {
										input = $('#input_media_url');
									}

									// Disable Button
								    button.text(settings.redirect_purchase).prop('disabled', true);

									// // Validation
									// if(input.val().length === 0) {
									// 	button.css('border', '1px solid red');
									// 	return false;
									// } else {
									// 	button.css( 'border', '1px solid green' );
									// }

									const data = {
										'action'		: 'submit_purchase',
										'input'			: input.val(),
										'method'		: option,
										'phone' 		: phone.val(),
										'random_amount' : random_amount.val(),
										'nonce'			: button.data('nonce'),
										'amount'		: amount,
									};

									$.post(settings.ajaxurl, data, function(response) {
										if(response.success) {
											window.location.href = response.data.redirect_url;
										}
									});

								});

							} else {
								$('#barhanmedia_calculated_plan').html(plan);
							}
						});
					}
				}

				// Enable Button
				button.text( settings.sent_label ).prop( 'disabled', false );
			});
		});



	});
})(jQuery)