jQuery(document)
		.ready(
				function($) {
					"use strict";

					if ($('.cs-cube-item').length == 0) {
						return;
					}

					var cube = $('.cs-cube-wrapper');

					/* get html curent slide. */
					var cube_html = cube.html();

					$(window).load(function() {
						
						cube_slide();
					});

					$(window).resize(function() {
						
						cube_slide();
					});

					function cube_slide() {
						
						if ($(window).width() <= 992) {

							cube_create_slide();
						} else {

							cube_restore_slide();
						}
					}

					function cube_create_slide() {

						/* create new html slide. */
						var new_html = '<div id="carousel-cube-generic" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';

						$(cube_html).find('.cs-cube-item').each(
								function(j) {
									
									var active = '';
									
									if(j === 0) { active = ' active'; }
									
									new_html = new_html + '<div class="item' + active + '">' + $(this).html() + '</div>';
								});

						new_html = new_html
								+ '';

						cube.html(new_html);
						
						cube.css('display', 'block');
					}

					function cube_restore_slide() {
						
						cube.html(cube_html);
						cube.css('display', 'block');
					}
				});