(function ($) {
	'use strict';

	$(document).ready(function () {

		$(function () {
			$("#mixed-boxes").mixItUp({
				selectors: {
					target: '.mix',
					filter: '.filter',
					sort: '.sort'
				},
				controls: {
					enable: true
				},
				animation: {
					enable: true,
					effects: 'fade scale',
					duration: 800
				}
			});
		});

		$("#menu").on("click", "a", function (event) {
			event.preventDefault();
			var id = $(this).attr('href'),
				top = $(id).offset().top;
			$('body,html').animate({
				scrollTop: top
			}, 1500);
		});

		$(window).scroll(function () {
			if ($(this).scrollTop() > 0) {
				$('#scroller').fadeIn(800);
			} else {
				$('#scroller').fadeOut(800);
			}
		});
		$('#scroller').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

	});
}(jQuery));