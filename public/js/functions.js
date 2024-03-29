(function ($) {

	"use strict";
	
	// Preload
	$(window).on('load', function () { // makes sure the whole site is loaded
		$('[data-loader="circle-side"]').fadeOut(); // will first fade out the loading animation
		$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('body').delay(350).css({
			'overflow': 'visible'
		});
	})
	
	// Submit loader mask 
	$('form#wrapped').on('submit', function () {
		var form = $("form#wrapped");
		form.validate();
		if (form.valid()) {
			$("#loader_form").fadeIn();
		}
	});

	// Jquery select
	$('.styled-select select').niceSelect();
	
	// Show Password
	$('#password1, #password2').hidePassword('focus', {
		toggle: {
			className: 'my-toggle'
		}
	});
	
	// Range slider
	$('input[type="range"]').rangeslider({
		polyfill: false,
		onInit: function () {
			this.output = $(".budget_slider span").html(this.$element.val());
		},
		onSlide: function (
			position, value) {
			this.output.html(value);
		}
	});
	
	// Button start scroll to section
    $('a[href^="#"].mobile_btn').on('click', function (e) {
			e.preventDefault();
			var target = this.hash;
			var $target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top
			}, 400, 'swing', function () {
				window.location.hash = target;
			});
		});

	// Date picker single + translation French + european date format
	$('input.date-pick-single-lang').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        autoApply: true,
        minDate: new Date(),
        showCustomRangeLabel: false,
         locale: {
         	separator:' > ',
         	direction: 'ltr',
	        format: 'DD/MM/YY',
	        applyLabel: 'Valider',
	        cancelLabel: 'Annuler',
	        fromLabel: 'De',
	        toLabel: 'à',
	        daysOfWeek: [
	            'Dim',
	            'Lun',
	            'Mar',
	            'Mer',
	            'Jeu',
	            'Ven',
	            'Sam'
	        ],
	        monthNames: [
	            'Janvier',
	            'Février',
	            'Mars',
	            'Avril',
	            'Mai',
	            'Juin',
	            'Juillet',
	            'Août',
	            'Septembre',
	            'Octobre',
	            'Novembre',
	            'Décembre'
	        ]
	    }
      }, function (chosen_date) {
		$('input.date-pick-single-lang').val(chosen_date.format('DD/MM/YY'));
	});

	// Date picker range
	$('input.date-pick-range').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: false,
        autoApply: true,
        minDate: new Date(),
        showCustomRangeLabel: false,
        locale: {
        	separator:' > ',
            direction: 'ltr',
            format: 'MM/DD/YY'
        }
    });
	 $('input.date-pick-range').on('apply.daterangepicker', function(ev, picker) {
	      $(this).val(picker.startDate.format('MM/DD/YY') + ' > ' + picker.endDate.format('MM/DD/YY'));
	});
	
	// Menu
	var overlayNav = $('.cd-overlay-nav'),
		overlayContent = $('.cd-overlay-content'),
		navigation = $('.cd-primary-nav'),
		toggleNav = $('.cd-nav-trigger');

	//inizialize navigation and content layers
  //layerInit();
	$(window).on('resize', function(){
		window.requestAnimationFrame(layerInit);
	});

	//open/close the menu and cover layers
	toggleNav.on('click', function(){
		if(!toggleNav.hasClass('close-nav')) {
			//it means navigation is not visible yet - open it and animate navigation layer
			toggleNav.addClass('close-nav');
		
				navigation.addClass('fade-in');
		} else {
			//navigation is open - close it and remove navigation layer
			toggleNav.removeClass('close-nav');
      navigation.removeClass('fade-in');
    }		
	});

	function layerInit(){
		var diameterValue = (Math.sqrt( Math.pow($(window).height(), 2) + Math.pow($(window).width(), 2))*2);
		overlayNav.children('span').velocity({
			scaleX: 0,
			scaleY: 0,
			translateZ: 0,
		}, 50).velocity({
			height : diameterValue+'px',
			width : diameterValue+'px',
			top : -(diameterValue/2)+'px',
			left : -(diameterValue/2)+'px',
		}, 0);

		overlayContent.children('span').velocity({
			scaleX: 0,
			scaleY: 0,
			translateZ: 0,
		}, 50).velocity({
			height : diameterValue+'px',
			width : diameterValue+'px',
			top : -(diameterValue/2)+'px',
			left : -(diameterValue/2)+'px',
		}, 0);
	}
	
})(window.jQuery); 
