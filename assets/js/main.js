jQuery(document).ready(function($) {
	"use strict";
	
	/* window */
	var window_width, window_height, scroll_top;
	
	/* admin bar */
	var adminbar = $('#wpadminbar');
	var adminbar_height = 0;
	
	/* header menu */
	var header = $('#cshero-header #cshero-header-navigation');
	var header_top = 0;
	
	/* scroll status */
	var scroll_status = '';
	
	/**
	 * window load event.
	 * 
	 * Bind an event handler to the "load" JavaScript event.
	 * @author Fox
	 */
	$(window).load(function() {
		
		/** current scroll */
		scroll_top = $(window).scrollTop();
		
		/** current window width */
		window_width = $(window).width();
		
		/** current window height */
		window_height = $(window).height();
		
		/* get admin bar height */
		adminbar_height = adminbar.length > 0 ? adminbar.outerHeight(true) : 0 ;
		
		/* get top header menu */
		header_top = adminbar_height;
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu(scroll_top);
		}
		
		/* count post share. */
		countpostshare();
		
		/* check mobile menu */
		cms_mobile_menu();
		
		/* page loading. */
		cms_page_loading();

		/* check back to top */
		if(CMSOptions.back_to_top == 1){
			/* add html. */
			$('body').append('<div id="back_to_top" class="back_to_top"><span class="go_up"><i style="" class="fa fa-angle-up"></i></span></div><!-- #back-to-top -->');
			cms_back_to_top();
		}
		
		/* check video size */
		cms_auto_video_width();

		//scroll_menu_mobile();

		//$(".cs-slider-wrapper .content").addClass('slider-show').css('opacity','1');
		//$(".cs-slider-magazine-wrapper").addClass('magazine-show');
		//$(".cs-cube-wrapper").addClass('cube-show');
	});

	/**
	 * reload event.
	 * 
	 * Bind an event handler to the "navigate".
	 */
	window.onbeforeunload = function(){ cms_page_loading(1); }
	
	/**
	 * resize event.
	 * 
	 * Bind an event handler to the "resize" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	$(window).resize(function(event, ui) {
		/** current window width */
		window_width = $(event.target).width();
		
		/** current window height */
		window_height = $(window).height();
		
		/** current scroll */
		scroll_top = $(window).scrollTop();
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu(scroll_top);
		}
		
		/* check mobile menu */
		cms_mobile_menu();
		
		/* check video size */
		cms_auto_video_width();

		//scroll_menu_mobile();

		cms_height_search();
	});
	
	/**
	 * scroll event.
	 * 
	 * Bind an event handler to the "scroll" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	var lastScrollTop = 0;
	
	$(window).scroll(function() {
		/** current scroll */
		scroll_top = $(window).scrollTop();
		/** check scroll up or down. */
		if(scroll_top < lastScrollTop) {
			/* scroll up. */
			scroll_status = 'up';
		} else {
			/* scroll down. */
			scroll_status = 'down';
		}
		
		lastScrollTop = scroll_top;
		
		/* check sticky menu. */
		if(CMSOptions.menu_sticky == '1'){
			cms_stiky_menu();
		}

		/* check sticky menu fixed page */
		if(CMSOptions.menu_sticky == '0'){
			cms_stiky_menu_fixed_page();
		}
		/* check back to top */
		cms_back_to_top();

	});

	/**
	 * Stiky menu
	 * 
	 * Show or hide sticky menu.
	 * @author Fox
	 * @since 1.0.0
	 */
	function cms_stiky_menu() {
		var el = $('#cshero-header-logo').outerHeight();
		if (scroll_top > el) {
			switch (true) {
				case (window_width > 991):
					header.addClass('cms-header-fixed');
					break;
			}
		} else {
			header.removeClass('cms-header-fixed');
		}
	}


	/**
	 * Back To Top
	 * 
	 * @author Fox
	 * @since 1.0.0
	 */
	$('body').on('click', '#back_to_top', function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1500);
    });

    /* Show or hide buttom  */
	function cms_back_to_top(){
		/* back to top */
        if (scroll_top < window_height) {
        	$('#back_to_top').addClass('off').removeClass('on');
        } else {
        	$('#back_to_top').removeClass('off').addClass('on');
        }
	}
	
	/**
	 * Mobile menu
	 * 
	 * Show or hide mobile menu.
	 * @author Fox
	 * @since 1.0.0
	 */
	
	$('body').on('click', '#cshero-menu-mobile', function(){
		var navigation = $(this).parent().find('#cshero-header-navigation');
		if(!navigation.hasClass('collapse')){
			navigation.addClass('collapse');
		} else {
			navigation.removeClass('collapse');
		}
	});
	/* check mobile screen. */
	function cms_mobile_menu() {
		var menu = $('#cshero-header-navigation');
		
		/* active mobile menu. */
		switch (true) {
		case (window_width <= 991 && window_width >= 768):
			menu.removeClass('phones-nav').addClass('tablets-nav');
			/* */
			cms_mobile_menu_group(menu);
			break;
		case (window_width <= 768):
			menu.removeClass('tablets-nav').addClass('phones-nav');
			break;
		default:
			menu.removeClass('mobile-nav tablets-nav');
			menu.find('li').removeClass('mobile-group');
			break;
		}	
	}
	/* group sub menu. */
	function cms_mobile_menu_group(nav) {
		nav.each(function(){
			$(this).find('li').each(function(){
				if($(this).find('ul:first').length > 0){
					$(this).addClass('mobile-group');
				}
			});
		});
	}
	
	/**
	 * Auto width video iframe
	 * 
	 * Youtube Vimeo.
	 * @author Fox
	 */
	function cms_auto_video_width() {
		$('.entry-video iframe').each(function(){
			var v_width = $(this).width();
			
			v_width = v_width / (16/9);
			$(this).attr('height',v_width + 35);
		})
	}
	
	
	/**
	 * Parallax.
	 * 
	 * @author Fox
	 * @since 1.0.0
	 */
	var cms_parallax = $('.cms_parallax');
	if(cms_parallax.length > 0 && CMSOptions.paralax == '1'){
		cms_parallax.each(function() {
			"use strict";
			var speed = $(this).attr('data-speed');
			
			speed = (speed != undefined && speed != '') ? speed : 0.1 ;
			
			$(this).parallax("50%", speed);
		});
	}
	
	/**
	 * ajax search.
	 * 
	 * @author FOX
	 */
	var ajaxtimer = null;
	
	$('#cms-ajax-search').on('keyup', function() {
		
		if($('.search-loading').length == 0){
			$('.page-search-content').addClass('active').html('<div class="loading-wrapper"><div class="search-loading"></div><span>LOADING</span></div>');
		}
		
		var s = $(this).val();
		
		clearTimeout(ajaxtimer);
		
		ajaxtimer = setTimeout(function() {
			
			$.post(ajaxurl, {
				'action' : 'ajax_search',
				'data' : s,
			}, function(response) {
				$('.page-search-content').addClass('active').html(response);
				cms_height_search();
				$('.page-search-content .search-wrapper').enscroll();
			});
			
		}, 1000);
	});
	
	/**
	 *  Search
	 */
	function cms_height_search () {
		$('.search-wrapper').css({'height': (($(window).height()) - 150)+'px'});
		$('.popup-inner').css({'height': (($(window).height()) - 150)+'px'});
	}

	/**
	 * Page Loading.
	 */
	function cms_page_loading($load) {
		switch ($load) {
		case 1:
			$('#cms-loadding').css('display','block')
			break;
		default:
			$('#cms-loadding').css('display','none')
			break;
		}
	}

	/* Popular Post Owl */
	if ( typeof $.fn.owlCarousel === 'function' && $(".cms-popular-post-wrapper").length ) {
		$(".cms-popular-post-wrapper").owlCarousel({
	        navigation : true,
	        slideSpeed : 300,
	        paginationSpeed : 400,
	        singleItem:true,
	        items : 1
	    });
	}

    /* Theme / gallery carousel (Owl) */
    if ( typeof $.fn.owlCarousel === 'function' ) {
	    $('.cms-theme-carousel').each(function(){
	    	var $carousel = $(this);
	    	if ( $carousel.hasClass('owl-loaded') ) {
	    		return;
	    	}
	    	$carousel.owlCarousel({
		        navigation : true,
		        smartSpeed : parseInt($carousel.attr('data-speed'), 10) || 1000,
		        paginationSpeed : 3000,
		        rewindSpeed: 1000,
		        singleItem:true,
		        items : parseInt($carousel.attr('data-item'), 10) || 1,
		        responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			        },
			        767:{
			            items: parseInt($carousel.attr('data-item'), 10) || 1,
			        },
			        992:{
			            items: parseInt($carousel.attr('data-item'), 10) || 1,
			        }
			    },
		        dots: false,
		        nav: true,
		        loop: ($carousel.attr('data-loop')) == '1' ? true : false,
		        autoplay: ($carousel.attr('data-auto-play')) == '1' ? true : false,
		        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
	    	});
	    });

	     $('.cms-post-image-carousel').each(function(){
	     	var $carousel = $(this);
	     	if ( $carousel.hasClass('owl-loaded') ) {
	     		return;
	     	}
	    	$carousel.owlCarousel({
		        navigation : true,
		        smartSpeed : parseInt($carousel.attr('data-speed'), 10) || 1000,
		        paginationSpeed : 1000,
		        rewindSpeed: 1000,
		        singleItem:true,
		        items : parseInt($carousel.attr('data-item'), 10) || 1,
		        dots: true,
		        nav: false,
		        loop: ($carousel.attr('data-loop')) == '1' ? true : false,
		        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
	    	});
	    });
    }
	
    
    /* Newletter */

    $('.newsletter-email').each(function() {
        if ($(this).val() === "Email") {
            $(this).val('');
        }
    });
    $('.newsletter-widget').find(".newsletter-email").each(function(ev) {
	     if(!$(this).val()) { 
	         $(this).attr("placeholder", "Your email address...");
	     }
 	});
    /* Page Popup, contact + search */
    $('.page-popup-wrapper .contact-page i').on('click', function(){
		$('body').find('.page-contact-popup').addClass('active');
	});
	$('.page-contact-popup .close').on('click', function(){
		$('body').find('.page-contact-popup').removeClass('active');
	});
	$('.page-popup-wrapper .search-page i').on('click', function(){
		$('body').find('.page-search-popup').addClass('active');
		$("#cms-ajax-search").focus();
	});
	$('.page-search-popup .close').on('click', function(){
		$('body').find('.page-search-popup').removeClass('active');
	});
	/* Add class menu active */
	$('#cshero-menu-mobile .icon-menu').on('click', function(){
		$('body').find('#cshero-header').toggleClass('menu-active');
	});
	/* Toggle social share (post-share / icon-share) */
	$(document).on('click', '.post-share .share-btn, .post-share .icon-share', function(e){
		e.preventDefault();
		e.stopPropagation();
		var $wrap = $(this).closest('.post-share');
		$('.post-share').not($wrap).removeClass('share-active');
		$wrap.toggleClass('share-active');
	});
	$(document).on('click', function(){
		$('.post-share').removeClass('share-active');
	});
	$(document).on('click', '.post-share .social-shared', function(e){
		e.stopPropagation();
	});

	/* Scroll Menu Mobile */
	function scroll_menu_mobile() {
		//$('.popup-inner').enscroll();
	}
	/* Mega Menu Offset */
	$( ".offset_1_column" ).parent().addClass('offset-1-columns');
	$( ".offset_2_column" ).parent().addClass('offset-2-columns');
	$( ".offset_3_column" ).parent().addClass('offset-3-columns');

	/* count sharing */
	function countpostshare() {
		
		if($('.blog-social-shared').length == 0) return;
		
		$('.blog-social-shared').each(function	() {
			
			countSharingInit($(this).attr('data-url'), $(this).find('.ico-shared span'));
		});
	}
	
	function countSharingInit(url, item_total) {
		
		var total = 0;
		
		/* facebook */
		$.getJSON("http://graph.facebook.com/?id="+ url +"", function(data) {
			if((data.shares != 0) && (data.shares != undefined) && (data.shares != null)) {
				total = total + parseInt(data.shares);
				item_total.html(total);
			}
		});
		
		/* twitter */
		$.getJSON("http://urls.api.twitter.com/1/urls/count.json?url="+ url +"&callback=?", function(data) {
			if((data.count != 0) && (data.count != undefined) && (data.count != null)) {
				total = total + parseInt(data.count);
				item_total.html(total);
			}
		});
		
		/* linkedIn */
		$.getJSON("http://www.linkedin.com/countserv/count/share?url="+url+"&callback=?", function(data) {
			if((data.count != 0) && (data.count != undefined) && (data.count != null)) {
				total = total + parseInt(data.count);
				item_total.html(total);
			}
		});
		
		/* pinterest */
		$.getJSON("http://api.pinterest.com/v1/urls/count.json?url="+url+"&callback=?", function(data) {
			if((data.count != 0) && (data.count != undefined) && (data.count != null)) {
				total = total + parseInt(data.count);
				item_total.html(total);
			}
		});
	}
});